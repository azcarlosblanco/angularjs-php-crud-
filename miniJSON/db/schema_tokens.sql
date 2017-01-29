CREATE TABLE tokens (
            tokenid   INTEGER PRIMARY KEY,
            username  varchar(255) NULL DEFAULT '',
            token     varchar(255) NULL DEFAULT '',
            timestamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
            );
