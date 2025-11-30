CREATE DATABASE IF NOT EXISTS batallanaval
    DEFAULT CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

USE batallanaval;


CREATE TABLE Usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nickname VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE
);



CREATE TABLE Contrasenas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    contrasena VARCHAR(255) NOT NULL,

    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);


CREATE TABLE Partida (
    id_partida INT AUTO_INCREMENT PRIMARY KEY,

    id_jugador INT NOT NULL,
    duracion_partida TIME NOT NULL,

    ganador_jugador INT NULL,
    gano_computadora BOOLEAN NOT NULL DEFAULT 0,

    fecha_partida DATE NOT NULL,

    FOREIGN KEY (id_jugador) REFERENCES Usuarios(id_usuario)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    FOREIGN KEY (ganador_jugador) REFERENCES Usuarios(id_usuario)
        ON UPDATE CASCADE
        ON DELETE SET NULL
);



INSERT INTO Usuarios (nickname, email)
VALUES
    ('Ana', 'josef@gmail.com');


INSERT INTO Contrasenas (id_usuario, contrasena)
VALUES
    (1, '$2y$10$7rC6TiCW3CJhkg1NCiytC.plK5wLm/fXt/dnYiCTQXBPlGe.ZCOaC');

INSERT INTO Partida (id_jugador, duracion_partida, ganador_jugador, gano_computadora, fecha_partida)
VALUES
    (1, '00:10:34', 1, 0, '2025-02-11'),
    (1, '00:06:02', NULL, 1, '2025-11-29'),
    (1, '00:01:51', NULL, 1, '2025-11-29');

COMMIT;
