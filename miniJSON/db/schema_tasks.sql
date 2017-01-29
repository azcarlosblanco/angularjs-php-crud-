CREATE TABLE tasks (taskId INTEGER PRIMARY KEY,
                    task varchar(200) NULL ,
                    status int(11) NULL ,
                    created_by varchar(255) NULL ,
                    created_at varchar(25) NULL ,
                    assigned_to varchar(255) NULL ,
                    due_date varchar(255) NULL ,
                    timestamp DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP);
