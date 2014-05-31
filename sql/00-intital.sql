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
