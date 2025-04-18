import numpy as np

# Load file .npy
X_train = np.load('X_train.npy')
y_train = np.load('y_bulan.npy')

# Lihat bentuk dan isi array
print("X_train shape:", X_train.shape)
print("y_train shape:", y_train.shape)

print("Contoh isi X_train:\n", X_train[:100])
print("Contoh isi y_train:\n", y_train[:100])
