CREATE TABLE yii2_frontimage_meta (
  id INT NOT NULL AUTO_INCREMENT,
  sort INT NOT NULL DEFAULT 1000000,
  image_id INT NULL,

  PRIMARY KEY (id),
  FOREIGN KEY (image_id) REFERENCES yii2_image_meta(id) ON DELETE CASCADE
);
CREATE TABLE yii2_frontimage_i18n (
  id INT NOT NULL,
  lang CHAR(2) NOT NULL,
  name VARCHAR(200) NOT NULL,
  body TEXT NOT NULL,
  
  PRIMARY KEY (id, lang),
  FOREIGN KEY (id) REFERENCES yii2_frontimage_meta(id) ON DELETE CASCADE
);
