from flask import Flask, request, jsonify
from sklearn.ensemble import RandomForestRegressor
from sklearn.model_selection import cross_val_score
import numpy as np

app = Flask(__name__)

# Load data saat API dijalankan
X_train = np.load("X_train.npy")
y_train = np.load("y_bulan.npy")

@app.route('/predict', methods=['POST'])
def predict():
    try:
        # Ambil data input dari request
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

        # Model Random Forest
        model = RandomForestRegressor(random_state=42)

        # Hitung cross-validation score untuk berbagai k
        k_values = [5, 10, 15, 20, 25]
        cv_scores = {}
        for k in k_values:
            try:
                mse_scores = -cross_val_score(model, X_train, y_train, cv=k, scoring='neg_mean_squared_error')
                cv_scores[k] = round(mse_scores.mean(), 4)
            except ValueError:
                # Misal jumlah sample terlalu kecil untuk k besar
                cv_scores[k] = None

        # Cari best k berdasarkan nilai MSE terkecil
        valid_scores = {k: mse for k, mse in cv_scores.items() if mse is not None}
        best_k = min(valid_scores, key=valid_scores.get)

        # Fit model dengan seluruh data
        model.fit(X_train, y_train)

        # Prediksi
        bulan_pred = float(model.predict(fitur_input)[0])

        # Format response
        return jsonify({
            "bulan": round(bulan_pred, 7),
            "best_k": best_k,
            "cv_mse": cv_scores
        })
    except Exception as e:
        return jsonify({"error": str(e)}), 500

if __name__ == '__main__':
    app.run(debug=True)
