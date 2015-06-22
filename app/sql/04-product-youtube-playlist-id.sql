DROP TABLE yii2_product_media;
ALTER TABLE yii2_product_meta ADD COLUMN youtube_playlist_id VARCHAR(255);

INSERT INTO yii2_contact_i18n (id, lang, department) VALUES
  (1, 'en', 'Manager'),
  (2, 'en', 'Construction'),
  (3, 'en', 'Engineering'),
  (4, 'en', 'Sales'),
  (5, 'en', 'Manufacturing'),
  (6, 'en', 'Administration');

ALTER TABLE yii2_tag_meta ADD COLUMN sort INT NOT NULL DEFAULT 1000000;