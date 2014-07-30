CREATE TABLE yii2_user (
  id INT NOT NULL AUTO_INCREMENT,
  username CHAR(10) NOT NULL,
  password CHAR(32) NOT NULL,
  accessToken CHAR(10) NOT NULL,
  authKey CHAR(20) NULL,

  PRIMARY KEY (id)
);

CREATE TABLE yii2_product_meta (
  id INT NOT NULL AUTO_INCREMENT,
  sort INT NOT NULL DEFAULT 1000000,
  parent_id INT NULL,

  PRIMARY KEY (id)
);
CREATE TABLE yii2_product_i18n (
  id INT NOT NULL,
  lang CHAR(2) NOT NULL,
  name VARCHAR(200) NOT NULL,
  body TEXT NOT NULL,
  shortcut_active CHAR(30) DEFAULT NULL,

  PRIMARY KEY (id, lang),
  FOREIGN KEY (id) REFERENCES yii2_product_meta(id) ON DELETE CASCADE
);

CREATE TABLE yii2_tag_meta (
  id INT NOT NULL AUTO_INCREMENT,
  
  PRIMARY KEY (id)
);
CREATE TABLE yii2_tag_i18n (
  id INT NOT NULL,
  lang CHAR(2) NOT NULL,
  name VARCHAR(200) NOT NULL,
  body TEXT NOT NULL,
  shortcut_active CHAR(30) DEFAULT NULL,

  PRIMARY KEY (id, lang),
  FOREIGN KEY (id) REFERENCES yii2_tag_meta(id) ON DELETE CASCADE
);

CREATE TABLE yii2_product_tag (
  product_id INT NOT NULL,
  tag_id INT NOT NULL,

  PRIMARY KEY (product_id, tag_id),
  FOREIGN KEY (product_id) REFERENCES yii2_product_meta(id) ON DELETE CASCADE,
  FOREIGN KEY (tag_id) REFERENCES yii2_tag_meta(id) ON DELETE CASCADE
);
CREATE TABLE yii2_product_media (
  id INT NOT NULL AUTO_INCREMENT,
  product_id INT NOT NULL,
  sort INT NOT NULL DEFAULT 1000000,
  url VARCHAR(100) NOT NULL,
  name VARCHAR(200) NOT NULL,

  PRIMARY KEY (id),
  KEY (product_id, sort),
  FOREIGN KEY (product_id) REFERENCES yii2_product_meta(id) ON DELETE CASCADE
);

CREATE TABLE yii2_image_meta (
  id INT NOT NULL AUTO_INCREMENT,
  fid INT NOT NULL,
  fmodel CHAR(30) NOT NULL,
  hash CHAR(32) NOT NULL,
  filename VARCHAR(250) NOT NULL,
  extension CHAR(5) NOT NULL,
  sort INT NOT NULL DEFAULT 1000000,

  PRIMARY KEY (id),
  KEY (fid, fmodel),
  KEY (hash)
);

CREATE TABLE yii2_shortcut (
  shortcut CHAR(30),
  action CHAR(30) NOT NULL,
  fid INT NOT NULL,
  fmodel CHAR(30) NOT NULL,
  
  PRIMARY KEY (shortcut),
  KEY (fid, fmodel)
);

CREATE TABLE yii2_contact_meta (
  id INT NOT NULL AUTO_INCREMENT,
  sort INT NOT NULL DEFAULT 1000000,
  name VARCHAR(100) NOT NULL,
  tel CHAR(20) NOT NULL,
  mobile CHAR(20) DEFAULT NULL,
  mail CHAR(30) DEFAULT NULL,
  skype CHAR(20) DEFAULT NULL,
  image_id INT DEFAULT NULL,

  PRIMARY KEY (id)
);
CREATE TABLE yii2_contact_i18n (
  id INT NOT NULL,
  lang CHAR(2) NOT NULL,
  department VARCHAR(50) NOT NULL,

  PRIMARY KEY (id, lang),
  FOREIGN KEY (id) REFERENCES yii2_contact_meta(id) ON DELETE CASCADE
);
