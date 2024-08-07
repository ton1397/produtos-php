CREATE DATABASE crud_produtos;
USE crud_produtos;
CREATE TABLE produtos(
    id INT NOT NULL auto_increment,
    nome VARCHAR(255) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    estoque INT NOT NULL,
    imagem VARCHAR(255) NOT NULL,
    PRIMARY KEY(id)
);
