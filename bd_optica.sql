-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tiempo de generación: 03-11-2025 a las 17:02:52
-- Versión del servidor: 5.0.51
-- Versión de PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Base de datos: `bd_optica`
-- 

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `privilegios`
-- 

CREATE TABLE `privilegios` (
  `idPrivilegio` int(11) NOT NULL auto_increment,
  `labelPrivilegio` varchar(150) NOT NULL,
  `pathPrivilegio` text NOT NULL,
  `iconPrivilegio` varchar(50) NOT NULL,
  PRIMARY KEY  (`idPrivilegio`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- Volcar la base de datos para la tabla `privilegios`
-- 

-- MÓDULO DE VENTAS
INSERT INTO `privilegios` VALUES (1, 'Emitir Boleta', '../salesModule/boletas/indexEmitirBoleta.php', 'boleta.png');
INSERT INTO `privilegios` VALUES (2, 'Emitir Proforma', '../salesModule/proformas/getEnlaceProforma.php', 'proforma.png');

-- MÓDULO DE CAJA / COMPROBANTES
INSERT INTO `privilegios` VALUES (3, 'Ver Comprobantes', '../salesModule/comprobantes/getEnlaceComprobante.php', 'factura.png');

-- MÓDULO DE INVENTARIO / LOGÍSTICA
INSERT INTO `privilegios` VALUES (4, 'Despacho', '../inventoryModule/despacho/indexRegistrarDespacho.php', 'camion.png');
INSERT INTO `privilegios` VALUES (5, 'Productos', '../inventoryModule/productos/indexProducto.php', 'lentes.png');

-- MÓDULO DE REPORTES
INSERT INTO `privilegios` VALUES (6, 'Rep. Ingresos', '../reportsModule/ingresos/indexReporteIngresos.php', 'grafico.png');
INSERT INTO `privilegios` VALUES (7, 'Rep. Stock', '../reportsModule/stock/indexReporteStock.php', 'lista.png');


-- 
-- Estructura de tabla para la tabla `usuarios`
-- 

CREATE TABLE `usuarios` (
  `login` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Volcar la base de datos para la tabla `usuarios`
-- 

INSERT INTO `usuarios` VALUES ('gato', '12345', 1);
INSERT INTO `usuarios` VALUES ('perro', '987654', 1);
INSERT INTO `usuarios` VALUES ('raton', '13579', 0);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `usuariosprivilegios`
-- 

CREATE TABLE `usuariosprivilegios` (
  `login` varchar(50) NOT NULL,
  `idPrivilegio` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Volcar la base de datos para la tabla `usuariosprivilegios`
--

INSERT INTO `usuariosprivilegios` VALUES ('gato', 1);
INSERT INTO `usuariosprivilegios` VALUES ('gato', 2);
INSERT INTO `usuariosprivilegios` VALUES ('gato', 3);
INSERT INTO `usuariosprivilegios` VALUES ('gato', 4);
INSERT INTO `usuariosprivilegios` VALUES ('gato', 5);
INSERT INTO `usuariosprivilegios` VALUES ('gato', 6);
INSERT INTO `usuariosprivilegios` VALUES ('gato', 7);


-- TABLA DE CLIENTES
CREATE TABLE clientes (
                          idCliente INT AUTO_INCREMENT PRIMARY KEY,
                          dni VARCHAR(8) NOT NULL UNIQUE,
                          nombres VARCHAR(100) NOT NULL,
                          direccion VARCHAR(200),
                          telefono VARCHAR(15),
                          estado INT DEFAULT 1
);

-- TABLA DE PRODUCTOS
CREATE TABLE productos (
                           idProducto INT AUTO_INCREMENT PRIMARY KEY,
                           nombre VARCHAR(100) NOT NULL,
                           precio DECIMAL(10,2) NOT NULL,
                           stock INT NOT NULL,
                           estado INT DEFAULT 1
);

-- TABLA DE PROFORMAS (Cabecera)
CREATE TABLE proformas (
                           idProforma INT AUTO_INCREMENT PRIMARY KEY,
                           idCliente INT NOT NULL,
                           fecha DATE NOT NULL,
                           total DECIMAL(10,2) NOT NULL,
                           estado VARCHAR(20) DEFAULT 'EMITIDA',
                           FOREIGN KEY (idCliente) REFERENCES clientes(idCliente)
);

-- TABLA DE DETALLES DE PROFORMA
CREATE TABLE detalles_proforma (
                                   idDetalle INT AUTO_INCREMENT PRIMARY KEY,
                                   idProforma INT NOT NULL,
                                   idProducto INT NOT NULL,
                                   cantidad INT NOT NULL,
                                   precioUnitario DECIMAL(10,2) NOT NULL,
                                   subtotal DECIMAL(10,2) NOT NULL,
                                   FOREIGN KEY (idProforma) REFERENCES proformas(idProforma),
                                   FOREIGN KEY (idProducto) REFERENCES productos(idProducto)
);

-- TABLA DE RECETAS (Para el caso de uso Receta Óptica)
CREATE TABLE recetas (
                         idReceta INT AUTO_INCREMENT PRIMARY KEY,
                         idCliente INT NOT NULL,
                         esfera_od VARCHAR(10),
                         cilindro_od VARCHAR(10),
                         eje_od VARCHAR(10),
                         esfera_oi VARCHAR(10),
                         cilindro_oi VARCHAR(10),
                         eje_oi VARCHAR(10),
                         fechaReceta DATE,
                         FOREIGN KEY (idCliente) REFERENCES clientes(idCliente)
);

-- DATOS DE PRUEBA
INSERT INTO clientes (dni, nombres, direccion) VALUES ('12345678', 'Juan Perez', 'Av. Siempre Viva 123');
INSERT INTO productos (nombre, precio, stock) VALUES ('Lentes Rayban', 450.00, 10), ('Resina UV', 80.00, 50);
INSERT INTO recetas (idCliente, fechaReceta, esfera_od) VALUES (1, NOW(), '-1.50');

CREATE TABLE metodo_pago (
    id_metodo_pago INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE tipo_comprobante (
    id_tipo_comprobante INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE pago (
    id_pago INT AUTO_INCREMENT PRIMARY KEY,
    id_metodo_pago INT NOT NULL,
    monto_total DECIMAL(10, 2) NOT NULL,
    fecha_pago DATETIME NOT NULL,
    FOREIGN KEY (id_metodo_pago) REFERENCES metodo_pago(id_metodo_pago)
);

CREATE TABLE comprobantes (
    id_comprobante INT AUTO_INCREMENT PRIMARY KEY,
    id_tipo_comprobante INT NOT NULL,
    id_proforma INT, 
    id_pago INT,
    numero_comprobante VARCHAR(20) NOT NULL UNIQUE,
    fecha_garantia DATE,
    estado CHAR(1) NOT NULL, -- 'E': Emitido, 'A': Anulado, 'P': Pendiente
    fecha_emision DATE NOT NULL,
    FOREIGN KEY (id_tipo_comprobante) REFERENCES tipo_comprobante(id_tipo_comprobante),
    FOREIGN KEY (id_pago) REFERENCES pago(id_pago)
);

INSERT INTO metodo_pago (nombre) VALUES 
('Efectivo'), 
('Tarjeta de Crédito'), 
('Yape');

INSERT INTO tipo_comprobante (nombre) VALUES 
('Boleta'), 
('Factura');

INSERT INTO pago (id_metodo_pago, monto_total, fecha_pago) VALUES 
(1, 150.50, NOW()), 
(2, 499.90, NOW()),
(1, 75.00, NOW());

INSERT INTO comprobantes (id_tipo_comprobante, id_proforma, id_pago, numero_comprobante, fecha_garantia, estado, fecha_emision) VALUES 
(1, 101, 1, 'B001-0000001', '2026-11-26', 'P', '2025-11-26'), 
(2, 102, 2, 'F001-0000002', '2026-11-26', 'E', '2025-11-26'), 
(1, 103, 3, 'B001-0000003', '2026-11-26', 'P', '2025-11-26');

INSERT INTO proformas (idCliente, fecha, total, estado)
VALUES (1, '2025-11-26', 250.50, 'P');
INSERT INTO detalles_proforma (idProforma, idProducto, cantidad, precioUnitario, subtotal)
VALUES (1, 1, 1, 250.50, 250.50);

INSERT INTO comprobantes (id_tipo_comprobante, id_proforma, id_pago, numero_comprobante, fecha_garantia, estado, fecha_emision)
VALUES (1, 1, 1, 'B001-0000100', '2026-11-26', 'P', '2025-11-26');