from flask import Flask, request, jsonify
import numpy as np
from joblib import load
import json

app = Flask(__name__)

# === Load model, scaler, dan nilai MAPE saat startup ===
model = load("best_rf_model.joblib")
scaler = load("scaler.joblib")

with open("best_mape.txt", "r") as f:
    best_mape = float(f.read())

with open("cv_mape_scores.json", "r") as f:
    cv_mape_scores = json.load(f)

@app.route('/predict', methods=['POST'])
def predict():
    try:
        data = request.get_json()
        fitur_input = np.array([[
            int(data['usia_mesin']),
            int(data['servis_terakhir_bulan']),
            int(data['jenis_pemeliharaan_1']),
            int(data.get('jenis_pemeliharaan_2', -1)),
            int(data.get('jenis_pemeliharaan_3', -1)),
            int(data['interval_km']),
            int(data['frekuensi_km_harian']),
            int(data['jam_operasi']),
            int(data['riwayat_masalah']),
        ]])

        fitur_input_scaled = scaler.transform(fitur_input)
        prediksi = model.predict(fitur_input_scaled)

        best_k = min(cv_mape_scores, key=lambda k: cv_mape_scores[k] if cv_mape_scores[k] is not None else float('inf'))
        return jsonify({
            "bulan": float(prediksi[0]),
            "mape": round(best_mape, 5),
            "cv_mape": cv_mape_scores,
            "best_k": int(best_k),
            "best_k_mape": round(cv_mape_scores[best_k], 5)
        })

    except Exception as e:
        return jsonify({"error": str(e)}), 500

if __name__ == '__main__':
    app.run(debug=True)
