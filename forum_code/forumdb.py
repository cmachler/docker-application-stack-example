#
# Database access functions for the web forum.
# 

import os
import time
import psycopg2
import bleach

## Database connection


## Get posts from database.
def GetAllPosts():
    '''Get all the posts from the database, sorted with the newest first.

    Returns:
      A list of dictionaries, where each dictionary has a 'content' key
      pointing to the post content, and 'time' key pointing to the time
      it was posted.
    '''
    params = {
      'database': 'forum',
      'user': os.environ['FORUM_POSTGRES_USER'],
      'password': os.environ['FORUM_POSTGRES_PASSWORD'],
      'host': 'forum_mariadb',
      'port': 5432
    }
    DB = psycopg2.connect(**params)
    c = DB.cursor()
    c.execute("SELECT time, content FROM posts ORDER BY time DESC")
    posts = ({'content': str(row[1]), 'time': str(row[0])} for row in c.fetchall())
    DB.close()
    return posts

## Add a post to the database.
def AddPost(content):
    '''Add a new post to the database.

    Args:
      content: The text content of the new post.
    '''
    content = bleach.clean(content, strip=True).strip()
    params = {
      'database': 'forum',
      'user': os.environ['FORUM_POSTGRES_USER'],
      'password': os.environ['FORUM_POSTGRES_PASSWORD'],
      'host': 'forum_mariadb',
      'port': 5432
    }
    DB = psycopg2.connect(**params)
    c = DB.cursor()
    c.execute("INSERT INTO posts VALUES (%s)" , (content,))
    DB.commit()
    DB.close()
