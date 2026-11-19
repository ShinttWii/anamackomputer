USE spk_macbook;

CREATE TABLE IF NOT EXISTS gejalas (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  kode VARCHAR(10) NOT NULL,
  nama VARCHAR(200) NOT NULL,
  deskripsi TEXT,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  PRIMARY KEY (id),
  UNIQUE KEY gejalas_kode_unique (kode)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS penyebabs (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  kode VARCHAR(10) NOT NULL,
  kerusakan_id BIGINT UNSIGNED NOT NULL,
  deskripsi TEXT NOT NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  PRIMARY KEY (id),
  UNIQUE KEY penyebabs_kode_unique (kode),
  CONSTRAINT penyebabs_kerusakan_id_foreign FOREIGN KEY (kerusakan_id) REFERENCES kerusakans (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS solusIs (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  kode VARCHAR(10) NOT NULL,
  kerusakan_id BIGINT UNSIGNED NOT NULL,
  deskripsi TEXT NOT NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  PRIMARY KEY (id),
  UNIQUE KEY solusIs_kode_unique (kode),
  CONSTRAINT solusIs_kerusakan_id_foreign FOREIGN KEY (kerusakan_id) REFERENCES kerusakans (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS aturans (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  kode VARCHAR(10) NOT NULL,
  kerusakan_id BIGINT UNSIGNED NOT NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  PRIMARY KEY (id),
  UNIQUE KEY aturans_kode_unique (kode),
  CONSTRAINT aturans_kerusakan_id_foreign FOREIGN KEY (kerusakan_id) REFERENCES kerusakans (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS aturan_gejalas (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  aturan_id BIGINT UNSIGNED NOT NULL,
  gejala_id BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY ag_unique (aturan_id, gejala_id),
  CONSTRAINT ag_aturan_foreign FOREIGN KEY (aturan_id) REFERENCES aturans (id) ON DELETE CASCADE,
  CONSTRAINT ag_gejala_foreign FOREIGN KEY (gejala_id) REFERENCES gejalas (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS konsultasis (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  model_macbook VARCHAR(100) DEFAULT NULL,
  hasil_kerusakan_id BIGINT UNSIGNED DEFAULT NULL,
  status_diagnosis ENUM('terdiagnosis','tidak_terdiagnosis') NOT NULL DEFAULT 'tidak_terdiagnosis',
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  PRIMARY KEY (id),
  CONSTRAINT konsultasis_kerusakan_foreign FOREIGN KEY (hasil_kerusakan_id) REFERENCES kerusakans (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS konsultasi_gejalas (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  konsultasi_id BIGINT UNSIGNED NOT NULL,
  gejala_id BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT kg_konsultasi_foreign FOREIGN KEY (konsultasi_id) REFERENCES konsultasis (id) ON DELETE CASCADE,
  CONSTRAINT kg_gejala_foreign FOREIGN KEY (gejala_id) REFERENCES gejalas (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
