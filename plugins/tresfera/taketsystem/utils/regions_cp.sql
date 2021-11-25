-- Base de datos de provincias, códigos postales y municipios.
-- Fecha: 12-MAR-2012
-- Versión: 1.0
--
-- (c) iFraktal Internet Matketing, S.L.
-- http://www.ifraktal.com/
--
-- Licencia: Se permite el uso y la alteración de estos archivos.
-- No se garantiza que los datos sean correctos o estén actualizados.
--
-- Basada en los datos de: http://codigos-postales.albin.es/

DROP TABLE IF EXISTS `tresfera_taketsystem_regions_cp`;
CREATE TABLE IF NOT EXISTS `tresfera_taketsystem_regions_cp` (
  `id` varchar(2) NOT NULL DEFAULT '0',
  `name` varchar(48) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


INSERT INTO `tresfera_taketsystem_regions_cp` (`id`, `name`) VALUES
('01', 'ARABA/&Aacute;LAVA'),
('02', 'ALBACETE'),
('03', 'ALICANTE'),
('04', 'ALMER&Iacute;A'),
('05', '&Aacute;VILA'),
('06', 'BADAJOZ'),
('07', 'ILLES BALEARS'),
('08', 'BARCELONA'),
('09', 'BURGOS'),
('10', 'C&Aacute;CERES'),
('11', 'C&Aacute;DIZ'),
('12', 'CASTELL&Oacute;N'),
('13', 'CIUDAD REAL'),
('14', 'C&Oacute;RDOBA'),
('15', 'CORU&Ntilde;A, A/LA'),
('16', 'CUENCA'),
('17', 'GIRONA/GERONA'),
('18', 'GRANADA'),
('19', 'GUADALAJARA'),
('20', 'GIPUZKOA/GUIPUZCOA'),
('21', 'HUELVA'),
('22', 'HUESCA'),
('23', 'JA&Eacute;N'),
('24', 'LE&Oacute;N'),
('25', 'LLEIDA/L&Eacute;RIDA'),
('26', 'LA RIOJA'),
('27', 'LUGO'),
('28', 'MADRID'),
('29', 'M&Aacute;LAGA'),
('30', 'MURCIA'),
('31', 'NAVARRA'),
('32', 'OURENSE'),
('33', 'ASTURIAS'),
('34', 'PALENCIA'),
('35', 'LAS PALMAS'),
('36', 'PONTEVEDRA'),
('37', 'SALAMANCA'),
('38', 'SANTA CRUZ DE TENERIFE'),
('39', 'CANTABRIA'),
('40', 'SEGOVIA'),
('41', 'SEVILLA'),
('42', 'SORIA'),
('43', 'TARRAGONA'),
('44', 'TERUEL'),
('45', 'TOLEDO'),
('46', 'VALENCIA'),
('47', 'VALLADOLID'),
('48', 'BIZKAIA/VIZCAYA'),
('49', 'ZAMORA'),
('50', 'ZARAGOZA'),
('51', 'CEUTA'),
('52', 'MELILLA');
