CREATE TABLE yii2_download_meta (
  id INT NOT NULL AUTO_INCREMENT,
  sort INT NOT NULL DEFAULT 1000000,
  filename VARCHAR(255) NOT NULL,
  filesize INT NOT NULL,

  PRIMARY KEY (id)
);
CREATE TABLE yii2_download_i18n (
  id INT NOT NULL,
  lang CHAR(2) NOT NULL,
  name VARCHAR(200) NOT NULL,
  body TEXT NOT NULL,
  shortcut_active CHAR(30) DEFAULT NULL,

  PRIMARY KEY (id, lang),
  FOREIGN KEY (id) REFERENCES yii2_download_meta(id)
);