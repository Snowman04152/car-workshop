import numpy as np
from sklearn.ensemble import RandomForestRegressor
from sklearn.model_selection import GridSearchCV, cross_val_score
from sklearn.metrics import make_scorer, mean_absolute_percentage_error
from sklearn.preprocessing import StandardScaler
from sklearn.datasets import make_regression
from joblib import dump
import json

# === Load data asli ===
X_train_asli = np.load("X_train_new.npy")
y_train_asli = np.load("y_bulan_new.npy")

# === Buat data sintetis ===
X_syn, y_syn = make_regression(
    n_samples=1000,
    n_features=9,
    noise=0.1,
    random_state=42
)
y_syn = np.abs(y_syn / 100)  # ubah skala ke bulan

# === Gabungkan data ===
X_train = np.vstack([X_train_asli, X_syn])
y_train = np.concatenate([y_train_asli, y_syn])

# === Scaling ===
scaler = StandardScaler()
X_scaled = scaler.fit_transform(X_train)

# === MAPE scorer ===
mape_scorer = make_scorer(mean_absolute_percentage_error, greater_is_better=False)

# === Grid Search untuk hyperparameter ===
param_grid = {
    "n_estimators": [100, 200],
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

# === Simpan model dan scaler ===
dump(grid_model.best_estimator_, "best_rf_model.joblib")
dump(scaler, "scaler.joblib")

# === Simpan MAPE dari GridSearch ===
with open("best_mape.txt", "w") as f:
    f.write(str(-grid_model.best_score_))

# === Hitung CV-MAPE dari model terbaik ===
cv_mape_scores = {}
for k in [5, 10, 15, 20, 25]:
    try:
        scores = -cross_val_score(grid_model.best_estimator_, X_scaled, y_train, cv=k, scoring=mape_scorer)
        cv_mape_scores[k] = round(scores.mean(), 5)
    except ValueError:
        cv_mape_scores[k] = None

with open("cv_mape_scores.json", "w") as f:
    json.dump(cv_mape_scores, f)

print("✅ Model retrained dengan data sintetis. MAPE dan model disimpan.")
