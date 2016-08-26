                CREATE TABLE IF NOT EXISTS `global_extrawatch_user` (
                id int auto_increment primary key,
                login varchar(255),
                password varchar(255),
                email varchar(255),
                active boolean,
                timeOfRegistration int);

                CREATE TABLE IF NOT EXISTS `global_extrawatch_project` (
                id int auto_increment primary key,
                userId int,
                url varchar(255),
                title varchar(255),
                timezone varchar(255),
                `email` varchar(255),
                active boolean
                ); 