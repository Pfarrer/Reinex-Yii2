CREATE TABLE yii2_download_meta (
  id INT NOT NULL AUTO_INCREMENT,
  hash CHAR(32) NOT NULL,
  filename VARCHAR(250) NOT NULL,
  extension CHAR(5) NOT NULL,
  sort INT NOT NULL DEFAULT 1000000,

  PRIMARY KEY (id)
);
CREATE TABLE yii2_download_i18n (
  id INT NOT NULL,
  lang CHAR(2) NOT NULL,
  name VARCHAR(200) NOT NULL,
  body TEXT NOT NULL,
  
  PRIMARY KEY (id, lang),
  FOREIGN KEY (id) REFERENCES yii2_download_meta(id)
);
