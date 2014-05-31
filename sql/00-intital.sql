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

  PRIMARY KEY (id)
);
CREATE TABLE product_i18n (
  id INT NOT NULL AUTO_INCREMENT,
  lang CHAR(2) NOT NULL,
  title VARCHAR(200) NOT NULL,
  body TEXT NOT NULL,

  PRIMARY KEY (id, lang)
);
