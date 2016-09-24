CREATE TABLE eostagram_tweet (
status_id TEXT PRIMARY KEY, 
text TEXT, 
media_url_1 TEXT, 
media_url_2 TEXT, 
media_url_3 TEXT, 
media_url_4 TEXT, 
created_at TEXT, 
screen_name TEXT, 
user_id TEXT, 
user_name TEXT, 
profile_image_url TEXT, 
rt_status_id TEXT, 
rt_created_at TEXT, 
rt_screen_name TEXT, 
rt_user_id TEXT, 
rt_user_name TEXT, 
rt_profile_image_url TEXT
);

CREATE INDEX screen_name_index ON
eostagram_tweet (screen_name);

CREATE INDEX rt_screen_name_index ON
eostagram_tweet (rt_screen_name);

