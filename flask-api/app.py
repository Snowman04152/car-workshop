from flask import Flask, request, jsonify
from sklearn.ensemble import RandomForestRegressor
from sklearn.model_selection import cross_val_score, GridSearchCV
from sklearn.metrics import make_scorer, mean_absolute_percentage_error
from sklearn.datasets import make_regression
from sklearn.preprocessing import StandardScaler
import numpy as np

app = Flask(__name__)

# === Load data asli ===
X_train = np.load("X_train_new.npy")
y_train = np.load("y_bulan_new.npy")

# === MAPE scorer ===
mape_scorer = make_scorer(mean_absolute_percentage_error, greater_is_better=False)

# === Fungsi Analisis Fitur Penting ===
def get_feature_importance(model, feature_names=None):
    importances = model.feature_importances_
    sorted_idx = np.argsort(importances)[::-1]
    return {
        f"f{idx}" if feature_names is None else feature_names[idx]: round(importances[idx], 5)
        for idx in sorted_idx
    }

@app.route('/predict', methods=['POST'])
def predict():
    try:
        # Ambil input dari frontend
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

        # === 1. Analisis Fitur Penting ===
        model_base = RandomForestRegressor(random_state=42)
        model_base.fit(X_train, y_train)
        feature_importance = get_feature_importance(model_base)

        # === 2. Buat data sintetis dan gabungkan ===
        X_syn, y_syn = make_regression(
            n_samples=1000,
            n_features=9,
            noise=0.1,
            random_state=42
        )
        y_syn = np.abs(y_syn / 100)  # ubah ke skala 'bulan'
        X_combined = np.vstack([X_train, X_syn])
        y_combined = np.concatenate([y_train, y_syn])

        # === 3. Evaluasi K-Fold MAPE pada data gabungan ===
        k_values = [5, 10, 15, 20, 25]
        cv_mape_scores = {}
        for k in k_values:
            try:
                model_eval = RandomForestRegressor(random_state=42)
                scores = -cross_val_score(model_eval, X_combined, y_combined, cv=k, scoring=mape_scorer)
                cv_mape_scores[k] = round(scores.mean(), 5)
            except ValueError:
                cv_mape_scores[k] = None

        # === 4. Optimasi GridSearch pada data asli ===
        X_scaled = StandardScaler().fit_transform(X_train)
        param_grid = {
            "n_estimators": [50, 100, 200],
            "max_depth": [None, 10, 20],
            "min_samples_split": [2, 5]
        }

        grid_model = GridSearchCV(
            RandomForestRegressor(random_state=42),
            param_grid=param_grid,
            cv=10,
            scoring=mape_scorer,
            n_jobs=-1
        )
        grid_model.fit(X_scaled, y_train)
        best_model = grid_model.best_estimator_

        # Prediksi input user
        fitur_input_scaled = StandardScaler().fit(X_train).transform(fitur_input)
        prediksi_bulan = float(best_model.predict(fitur_input_scaled)[0])

        return jsonify({
            "bulan": round(prediksi_bulan, 7),
            "feature_importance": feature_importance,
            "best_params": grid_model.best_params_,
            "best_mape_asli": round(-grid_model.best_score_, 5),
            "cv_mape_gabungan": cv_mape_scores
        })

    except Exception as e:
        return jsonify({"error": str(e)}), 500

if __name__ == '__main__':
    app.run(debug=True)
