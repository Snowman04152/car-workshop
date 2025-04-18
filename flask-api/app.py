from flask import Flask, request, jsonify
from sklearn.naive_bayes import GaussianNB
import numpy as np

app = Flask(__name__)

# Load data dari file eksternal
X_train = np.load("X_train.npy")
y_bulan = np.load("y_bulan.npy")

# Model Naive Bayes
model_bulan = GaussianNB()
model_bulan.fit(X_train, y_bulan)

@app.route('/predict', methods=['POST'])
def predict():
    try:
        data = request.get_json()
        usia_mesin = int(data['usia_mesin'])
        servis_terakhir_bulan = int(data['servis_terakhir_bulan'])
        jenis_1 = int(data['jenis_pemeliharaan_1'])
        jenis_2 = int(data.get('jenis_pemeliharaan_2', -1))
        jenis_3 = int(data.get('jenis_pemeliharaan_3', -1))
        interval_km = int(data['interval_km'])
        frekuensi_km_harian = int(data['frekuensi_km_harian'])
        jam_operasi = int(data['jam_operasi'])
        riwayat_masalah = int(data['riwayat_masalah'])

        fitur = np.array([[usia_mesin, servis_terakhir_bulan, 
                           jenis_1, jenis_2, jenis_3,
                           interval_km, frekuensi_km_harian, jam_operasi,
                           riwayat_masalah]])

        prediksi_bulan = int(model_bulan.predict(fitur)[0])
        return jsonify({'bulan': prediksi_bulan})
    except Exception as e:
        return jsonify({'error': str(e)}), 500

if __name__ == '__main__':
    app.run(debug=True)
