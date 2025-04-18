
import pandas as pd
import numpy as np

jenis_pemeliharaan_encoder = {
    "Charging Accu": 1,
    "Ganti Bumper Belakang": 2,
    "Ganti Bumper Depan": 3,
    "Ganti Kampas Rem": 4,
    "Ganti Lampu Depan": 5,
    "Ganti Minyak Rem": 6,
    "Ganti Oli": 7,
    "Pemeriksaan Filter Udara": 8,
    "Pemeriksaan Kampas Rem": 9,
    "Pemeriksaan Kelistrikan": 10,
    "Pemeriksaan Minyak Rem": 11,
    "Pemeriksaan Rem": 12,
    "Pemeriksaan Suspensi": 13,
    "Pemeriksaan Sistem Pendingin": 14,
    "Pemeriksaan Sistem Pengapian": 15,
    "Pemeriksaan Transmisi": 16,
    "Perbaikan Bumper Depan": 17,
    "Pergantian Busi": 18,
    "Pergantian Kampas Rem": 19,
    "Pergantian Oli": 20,
    "Service Berkala": 21,
    "Service Kopling": 22,
    "Tune Up": 23,
    "Rotasi Ban": 24
}

def map_kerusakan(kerusakan_str):
    jenis = [x.strip().title() for x in kerusakan_str.split(',')]
    mapped = [jenis_pemeliharaan_encoder.get(j, -1) for j in jenis]
    return (mapped + [-1] * 3)[:3]

def proses_data(file_path):
    df = pd.read_excel(file_path)
    required_columns = [
        "Usia Mesin", "Servis Bulan", "Kerusakan", "Interval (KM)",
        "Frekuensi Harian (KM)", "Jam Operasi (per bulan)",
        "Bulan Pemeliharaan Selanjutnya", "Riwayat Masalah"
    ]
    df = df.dropna(subset=required_columns)
    df["Riwayat Masalah"] = df["Riwayat Masalah"].apply(
        lambda x: 1 if "Masalah Mesin Usia Lanjut" in str(x) else 0
    )
    
    X_data = []
    y_data = []

    for _, row in df.iterrows():
        usia = int(row["Usia Mesin"])
        servis_bulan = int(row["Servis Bulan"])
        interval = int(row["Interval (KM)"])
        frekuensi = int(row["Frekuensi Harian (KM)"])
        jam_operasi = int(row["Jam Operasi (per bulan)"])
        bulan_selanjutnya = int(row["Bulan Pemeliharaan Selanjutnya"])
        riwayat = int(row["Riwayat Masalah"])
        
        jenis = map_kerusakan(str(row["Kerusakan"]))
        x_row = [usia, servis_bulan] + jenis + [interval, frekuensi, jam_operasi, riwayat]
        X_data.append(x_row)
        y_data.append(bulan_selanjutnya)

    X_train = np.array(X_data)
    y_bulan = np.array(y_data)
    return X_train, y_bulan

# Contoh penggunaan:
# X_train, y_bulan = proses_data("train.xlsx")
