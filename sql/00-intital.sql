CREATE TABLE user (
  id INT NOT NULL AUTO_INCREMENT,
  username CHAR(10) NOT NULL,
  password CHAR(32) NOT NULL,
  accessToken CHAR(10) NOT NULL,
  authKey CHAR(20) NULL,

  PRIMARY KEY (id)
);

INSERT INTO user (username, password, accessToken)
  VALUES ('brian', MD5('abc123'), 'jf9)J§P*8s');

CREATE TABLE product_meta (
  id INT NOT NULL AUTO_INCREMENT,
  sort INT NOT NULL DEFAULT 1000000,
  parent_id INT NULL,

  PRIMARY KEY (id)
);
CREATE TABLE product_i18n (
  id INT NOT NULL AUTO_INCREMENT,
  lang CHAR(2) NOT NULL,
  name VARCHAR(200) NOT NULL,
  body TEXT NOT NULL,

  PRIMARY KEY (id, lang)
);

CREATE TABLE tag_meta (
  id INT NOT NULL AUTO_INCREMENT,
  
  PRIMARY KEY (id)
);
CREATE TABLE tag_i18n (
  id INT NOT NULL AUTO_INCREMENT,
  lang CHAR(2) NOT NULL,
  name VARCHAR(200) NOT NULL,
  body TEXT NOT NULL,

  PRIMARY KEY (id, lang)
);

CREATE TABLE image_meta (
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
