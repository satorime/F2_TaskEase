-- ============================================================
-- TaskEase Database Schema for Supabase (PostgreSQL)
-- ============================================================
-- HOW TO USE:
--   1. Go to https://app.supabase.com and open your project.
--   2. Click "SQL Editor" in the left sidebar.
--   3. Paste this entire file and click "Run".
-- ============================================================

-- User accounts (login credentials)
CREATE TABLE IF NOT EXISTS tbluseraccount (
    acctid   SERIAL PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    emailadd VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- User profile info linked to account
CREATE TABLE IF NOT EXISTS tbluserprofile (
    userid    SERIAL PRIMARY KEY,
    firstname VARCHAR(255) NOT NULL,
    lastname  VARCHAR(255) NOT NULL,
    acctid    INTEGER REFERENCES tbluseraccount(acctid) ON DELETE CASCADE
);

-- Active tasks
CREATE TABLE IF NOT EXISTS tbltask (
    taskid          SERIAL PRIMARY KEY,
    taskname        VARCHAR(255) UNIQUE NOT NULL,
    taskdescription TEXT,
    taskdate        VARCHAR(50),
    isimportant     SMALLINT DEFAULT 0
);

-- Soft-deleted tasks (trash / recycle bin)
CREATE TABLE IF NOT EXISTS tbltaskdeleted (
    id              SERIAL PRIMARY KEY,
    taskname        VARCHAR(255),
    taskdescription TEXT,
    taskdate        VARCHAR(50),
    deleted_date    TIMESTAMP DEFAULT NOW(),
    is_active       SMALLINT DEFAULT 1
);

-- Legacy important-task table (kept for compatibility)
CREATE TABLE IF NOT EXISTS tblimportanttask (
    id              SERIAL PRIMARY KEY,
    taskname        VARCHAR(255),
    taskdescription TEXT,
    taskdate        VARCHAR(50)
);
