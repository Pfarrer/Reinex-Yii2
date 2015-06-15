ALTER TABLE yii2_user MODIFY COLUMN password VARCHAR(255) NOT NULL;
UPDATE yii2_user SET password = '';
-- Example password: $2y$13$4hRdY7RvINgb31z/s78jOeCJEyriMy4BBUoh8vq/E9G6KdYBeAzcO