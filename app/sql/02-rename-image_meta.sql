RENAME TABLE yii2_image_meta TO yii2_image;

UPDATE yii2_image SET fmodel='app\\models\\FrontimageMeta' WHERE fmodel='app\\models\\MetaFrontimage';
UPDATE yii2_image SET fmodel='app\\models\\ProductMeta' WHERE fmodel='app\\models\\MetaProduct';