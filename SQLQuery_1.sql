create table contas (
    logins varchar (50) not null primary key,
    senha int (18) not null
    );


    select * from contas;

    drop table contas;

    insert into contas (logins, senha) values(
        "", "kkkkkk")


CREATE TRIGGER antes_inserir_senha BEFORE INSERT ON contas
    FOR EACH ROW
        BEGIN
            IF NEW.senha = '' THEN
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Não é permitido inserir uma string vazia.';
            END IF;
        END;