.mode columns 
.headers on

DROP TABLE IF EXISTS agent_departments;
DROP TABLE IF EXISTS ticket_faqs;
DROP TABLE IF EXISTS ticket_hashtags;
DROP TABLE IF EXISTS tickets;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS hashtags;
DROP TABLE IF EXISTS departments;
DROP TABLE IF EXISTS faqs;

CREATE TABLE departments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE hashtags (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    role VARCHAR(10) NOT NULL DEFAULT 'client' CHECK (role IN ('client', 'agent', 'admin')),
    department_id INTEGER,
    FOREIGN KEY(department_id) REFERENCES departments(id)
);


CREATE TABLE tickets (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    client_id INTEGER NOT NULL,
    agent_id INTEGER,
    status VARCHAR(10) NOT NULL DEFAULT 'open' CHECK (status IN ('open', 'assigned', 'closed')),
    priority VARCHAR(10) NOT NULL DEFAULT 'medium' CHECK (priority IN ('low', 'medium', 'high')),
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    department_id INTEGER,
    FOREIGN KEY(client_id) REFERENCES users(id),
    FOREIGN KEY(agent_id) REFERENCES users(id),
    FOREIGN KEY(department_id) REFERENCES departments(id)
);

CREATE TABLE faqs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    question TEXT NOT NULL,
    answer TEXT NOT NULL
);

CREATE TABLE ticket_hashtags (
    ticket_id INTEGER NOT NULL,
    hashtag_id INTEGER NOT NULL,
    PRIMARY KEY (ticket_id, hashtag_id),
    FOREIGN KEY(ticket_id) REFERENCES tickets(id),
    FOREIGN KEY(hashtag_id) REFERENCES hashtags(id)
);

CREATE TABLE ticket_faqs (
    ticket_id INTEGER NOT NULL,
    faq_id INTEGER NOT NULL,
    PRIMARY KEY (ticket_id, faq_id),
    FOREIGN KEY(ticket_id) REFERENCES tickets(id),
    FOREIGN KEY(faq_id) REFERENCES faqs(id)
);

