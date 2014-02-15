-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 11/06/2013 às 13h36min
-- Versão do Servidor: 5.5.16
-- Versão do PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `sgo`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `acusado`
--

CREATE TABLE IF NOT EXISTS `acusado` (
  `id_acusado` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `telefone` varchar(10) NOT NULL,
  `data_nasc` date NOT NULL,
  `sexo` char(1) NOT NULL,
  `caracteristicas` text NOT NULL,
  `genitora` varchar(50) NOT NULL,
  `id_end` int(11) NOT NULL,
  PRIMARY KEY (`id_acusado`),
  KEY `fk_end2` (`id_end`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `acusado`
--

INSERT INTO `acusado` (`id_acusado`, `nome`, `telefone`, `data_nasc`, `sexo`, `caracteristicas`, `genitora`, `id_end`) VALUES
(1, 'CLEBER DE MELO MESQUITA', '3384-4343', '1983-03-16', 'M', 'ALTO, MAGRO , LOURO, TATUUAGEM NO BRAÇO...', 'MARIA DO CARMO MESQUITA', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ap_arma`
--

CREATE TABLE IF NOT EXISTS `ap_arma` (
  `id_aa` int(11) NOT NULL AUTO_INCREMENT,
  `qtde` int(11) NOT NULL,
  `descricao` text NOT NULL,
  `id_arma` int(11) NOT NULL,
  `id_ocorrencia` int(11) NOT NULL,
  `id_crime` int(11) NOT NULL,
  PRIMARY KEY (`id_aa`),
  KEY `fk_arma` (`id_arma`),
  KEY `fk_ap_arma_ocorrencia_crime1` (`id_ocorrencia`,`id_crime`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `ap_arma`
--

INSERT INTO `ap_arma` (`id_aa`, `qtde`, `descricao`, `id_arma`, `id_ocorrencia`, `id_crime`) VALUES
(1, 1, '1 REVÓLVER CALIBRE 38, MARCA TAURUS, NUMERAÇÃO PC1234.', 1, 1, 6);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ap_carro`
--

CREATE TABLE IF NOT EXISTS `ap_carro` (
  `id_ac` int(11) NOT NULL AUTO_INCREMENT,
  `qtde` varchar(45) NOT NULL,
  `descricao` text NOT NULL,
  `id_ocorrencia` int(11) NOT NULL,
  `id_crime` int(11) NOT NULL,
  PRIMARY KEY (`id_ac`),
  KEY `fk_ap_carro_ocorrencia_crime1` (`id_ocorrencia`,`id_crime`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ap_droga`
--

CREATE TABLE IF NOT EXISTS `ap_droga` (
  `id_ad` int(11) NOT NULL AUTO_INCREMENT,
  `qtde` int(11) NOT NULL,
  `descricao` text NOT NULL,
  `id_droga` int(11) NOT NULL,
  `id_ocorrencia` int(11) NOT NULL,
  `id_crime` int(11) NOT NULL,
  PRIMARY KEY (`id_ad`),
  KEY `fk_droga` (`id_droga`),
  KEY `fk_ap_droga_ocorrencia_crime1` (`id_ocorrencia`,`id_crime`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `area`
--

CREATE TABLE IF NOT EXISTS `area` (
  `id_area` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` text NOT NULL,
  `id_muni` int(11) NOT NULL,
  PRIMARY KEY (`id_area`),
  KEY `muni` (`id_muni`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `area`
--

INSERT INTO `area` (`id_area`, `descricao`, `id_muni`) VALUES
(1, 'Área do Jereissati II', 2),
(2, 'Área do Vila das Flores', 2),
(3, 'Área do Horto Florestal', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `arma`
--

CREATE TABLE IF NOT EXISTS `arma` (
  `id_arma` int(11) NOT NULL AUTO_INCREMENT,
  `arma` varchar(100) NOT NULL,
  PRIMARY KEY (`id_arma`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `arma`
--

INSERT INTO `arma` (`id_arma`, `arma`) VALUES
(1, 'REVÓLVER'),
(2, 'PÍSTOLA'),
(3, 'GARRONCHA'),
(4, 'ESPINGARDA'),
(5, 'ARMA BRANCA');

-- --------------------------------------------------------

--
-- Estrutura da tabela `bairro`
--

CREATE TABLE IF NOT EXISTS `bairro` (
  `id_bairro` int(11) NOT NULL AUTO_INCREMENT,
  `bairro` varchar(50) NOT NULL,
  `id_muni` int(11) NOT NULL,
  `id_area` int(11) NOT NULL,
  PRIMARY KEY (`id_bairro`),
  UNIQUE KEY `id_bairro_UNIQUE` (`id_bairro`),
  KEY `area_fk` (`id_area`),
  KEY `fk_bairro_muni` (`id_muni`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `bairro`
--

INSERT INTO `bairro` (`id_bairro`, `bairro`, `id_muni`, `id_area`) VALUES
(1, 'VILA DAS FLORES', 2, 2),
(2, 'JEREISSATI II', 2, 1),
(3, 'HORTO', 1, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `crime`
--

CREATE TABLE IF NOT EXISTS `crime` (
  `id_crime` int(11) NOT NULL AUTO_INCREMENT,
  `crime` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_crime`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Extraindo dados da tabela `crime`
--

INSERT INTO `crime` (`id_crime`, `crime`) VALUES
(1, 'HOMICÍDIO'),
(2, 'LESÃO CORPORAL'),
(3, 'ROUBO'),
(4, 'ESTUPRO'),
(5, 'APREENSÃO DE DROGAS'),
(6, 'APREENSÃO DE ARMAS'),
(7, 'APREENSÃO DE CARRO');

-- --------------------------------------------------------

--
-- Estrutura da tabela `droga`
--

CREATE TABLE IF NOT EXISTS `droga` (
  `id_droga` int(11) NOT NULL AUTO_INCREMENT,
  `droga` varchar(100) NOT NULL,
  PRIMARY KEY (`id_droga`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `droga`
--

INSERT INTO `droga` (`id_droga`, `droga`) VALUES
(1, 'MACONHA'),
(2, 'CRACK'),
(3, 'COCAÍNA'),
(4, 'LSD');

-- --------------------------------------------------------

--
-- Estrutura da tabela `endereco`
--

CREATE TABLE IF NOT EXISTS `endereco` (
  `id_endereco` int(11) NOT NULL AUTO_INCREMENT,
  `rua` varchar(255) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `id_bairro` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_endereco`),
  KEY `fk_bairro` (`id_bairro`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `endereco`
--

INSERT INTO `endereco` (`id_endereco`, `rua`, `numero`, `id_bairro`) VALUES
(1, 'RUA 12', '194', 1),
(2, 'RUA 74', '234', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `graduacao`
--

CREATE TABLE IF NOT EXISTS `graduacao` (
  `id_grad` int(11) NOT NULL AUTO_INCREMENT,
  `sigla` varchar(5) NOT NULL,
  `graduacao` varchar(20) NOT NULL,
  PRIMARY KEY (`id_grad`),
  UNIQUE KEY `sigla_UNIQUE` (`sigla`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `graduacao`
--

INSERT INTO `graduacao` (`id_grad`, `sigla`, `graduacao`) VALUES
(1, 'SD', 'Soldado'),
(2, 'CB', 'Cabo'),
(3, 'SGT', 'Sargento'),
(4, 'TEN', 'Tenente');

-- --------------------------------------------------------

--
-- Estrutura da tabela `homicidio`
--

CREATE TABLE IF NOT EXISTS `homicidio` (
  `id_homi` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_homi` varchar(200) DEFAULT NULL,
  `qtde` int(11) DEFAULT NULL,
  `id_ocorrencia` int(11) NOT NULL,
  `id_crime` int(11) NOT NULL,
  PRIMARY KEY (`id_homi`),
  KEY `fk_homicidio_ocorrencia_crime1` (`id_ocorrencia`,`id_crime`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `lesao`
--

CREATE TABLE IF NOT EXISTS `lesao` (
  `id_les` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_les` varchar(200) NOT NULL,
  `qtde` int(11) NOT NULL,
  `id_ocorrencia` int(11) NOT NULL,
  `id_crime` int(11) NOT NULL,
  PRIMARY KEY (`id_les`),
  KEY `fk_lesao_ocorrencia_crime1` (`id_ocorrencia`,`id_crime`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `acao` varchar(10) NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `usuario` int(11) NOT NULL,
  `id_oco` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `log`
--

INSERT INTO `log` (`acao`, `data`, `hora`, `usuario`, `id_oco`) VALUES
('Cadastrou', '2013-06-11', '08:31:10', 1, 1),
('Alterou', '2013-06-11', '08:35:33', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `manutencao`
--

CREATE TABLE IF NOT EXISTS `manutencao` (
  `id_man` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(255) NOT NULL,
  PRIMARY KEY (`id_man`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `manutencao`
--

INSERT INTO `manutencao` (`id_man`, `tipo`) VALUES
(1, 'TROCA DE ÓLEO'),
(2, 'REVISÃO GERAL');

-- --------------------------------------------------------

--
-- Estrutura da tabela `municipio`
--

CREATE TABLE IF NOT EXISTS `municipio` (
  `id_muni` int(11) NOT NULL AUTO_INCREMENT,
  `municipio` varchar(100) NOT NULL,
  PRIMARY KEY (`id_muni`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `municipio`
--

INSERT INTO `municipio` (`id_muni`, `municipio`) VALUES
(1, 'Maracanaú'),
(2, 'Pacatuba');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ocorrencia`
--

CREATE TABLE IF NOT EXISTS `ocorrencia` (
  `id_ocorrencia` int(11) NOT NULL AUTO_INCREMENT,
  `id_end` int(11) NOT NULL,
  `id_vtr` int(11) NOT NULL,
  `id_area` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `data` date NOT NULL,
  `horario` varchar(5) NOT NULL,
  `narracao` text NOT NULL,
  PRIMARY KEY (`id_ocorrencia`),
  KEY `fk_end_oco` (`id_end`),
  KEY `fk_vtr_oco` (`id_vtr`),
  KEY `fk_area_oco` (`id_area`),
  KEY `fk_usuario_oco` (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `ocorrencia`
--

INSERT INTO `ocorrencia` (`id_ocorrencia`, `id_end`, `id_vtr`, `id_area`, `id_usuario`, `data`, `horario`, `narracao`) VALUES
(1, 2, 1, 1, 1, '2013-06-06', '20:54', 'VIATURA FOI ACIONADA VIA CIOPS PARA UMA OCORRÊNCIA DE ROUBO.\r\nAO CHEGAR AO LOCAL O ELEMENTO  FOI PRESO COM TODO O MATERIAL ROUBADO E UMA ARMA FOI APRRENDIDA.');

--
-- Gatilhos `ocorrencia`
--
DROP TRIGGER IF EXISTS `Tgr_inseri_log`;
DELIMITER //
CREATE TRIGGER `Tgr_inseri_log` AFTER INSERT ON `ocorrencia`
 FOR EACH ROW BEGIN
      INSERT INTO log SET
   
          acao = 'Cadastrou',
          data = CURDATE(),
          hora = CURTIME(),
          usuario = NEW.id_usuario,
          id_oco = NEW.id_ocorrencia;

END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `Tgr_altera_log`;
DELIMITER //
CREATE TRIGGER `Tgr_altera_log` BEFORE UPDATE ON `ocorrencia`
 FOR EACH ROW BEGIN
      INSERT INTO log SET
   
          acao = 'Alterou',
          data = CURDATE(),
          hora = CURTIME(),
          usuario = NEW.id_usuario,
          id_oco = NEW.id_ocorrencia;

END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ocorrencia_acusado`
--

CREATE TABLE IF NOT EXISTS `ocorrencia_acusado` (
  `id_ocorrencia` int(11) NOT NULL,
  `id_acusado` int(11) NOT NULL,
  PRIMARY KEY (`id_ocorrencia`,`id_acusado`),
  KEY `fk_ocorrencia_has_acusado_acusado1` (`id_acusado`),
  KEY `fk_ocorrencia_has_acusado_ocorrencia1` (`id_ocorrencia`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `ocorrencia_acusado`
--

INSERT INTO `ocorrencia_acusado` (`id_ocorrencia`, `id_acusado`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ocorrencia_crime`
--

CREATE TABLE IF NOT EXISTS `ocorrencia_crime` (
  `id_ocorrencia` int(11) NOT NULL,
  `id_crime` int(11) NOT NULL,
  PRIMARY KEY (`id_ocorrencia`,`id_crime`),
  KEY `fk_ocorrencia_has_crime_crime1` (`id_crime`),
  KEY `fk_ocorrencia_has_crime_ocorrencia1` (`id_ocorrencia`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `ocorrencia_crime`
--

INSERT INTO `ocorrencia_crime` (`id_ocorrencia`, `id_crime`) VALUES
(1, 3),
(1, 6);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ocorrencia_policial`
--

CREATE TABLE IF NOT EXISTS `ocorrencia_policial` (
  `id_ocorrencia` int(11) NOT NULL,
  `id_policial` int(11) NOT NULL,
  PRIMARY KEY (`id_ocorrencia`,`id_policial`),
  KEY `fk_ocorrencia_has_policial_policial1` (`id_policial`),
  KEY `fk_ocorrencia_has_policial_ocorrencia1` (`id_ocorrencia`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `ocorrencia_policial`
--

INSERT INTO `ocorrencia_policial` (`id_ocorrencia`, `id_policial`) VALUES
(1, 1),
(1, 2),
(1, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ocorrencia_vitima`
--

CREATE TABLE IF NOT EXISTS `ocorrencia_vitima` (
  `id_ocorrencia` int(11) NOT NULL,
  `id_vitima` int(11) NOT NULL,
  PRIMARY KEY (`id_ocorrencia`,`id_vitima`),
  KEY `fk_vit` (`id_vitima`),
  KEY `fk_oco` (`id_ocorrencia`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `ocorrencia_vitima`
--

INSERT INTO `ocorrencia_vitima` (`id_ocorrencia`, `id_vitima`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `policial`
--

CREATE TABLE IF NOT EXISTS `policial` (
  `id_policial` int(11) NOT NULL AUTO_INCREMENT,
  `id_graduacao` int(11) NOT NULL,
  `numeral` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `nome_guerra` varchar(50) NOT NULL,
  `matricula` varchar(12) NOT NULL,
  `data_nasc` date NOT NULL,
  `sexo` char(1) NOT NULL,
  PRIMARY KEY (`id_policial`),
  UNIQUE KEY `matricula_UNIQUE` (`matricula`),
  UNIQUE KEY `numeral_UNIQUE` (`numeral`),
  KEY `grad2` (`id_graduacao`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 PACK_KEYS=0 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `policial`
--

INSERT INTO `policial` (`id_policial`, `id_graduacao`, `numeral`, `nome`, `nome_guerra`, `matricula`, `data_nasc`, `sexo`) VALUES
(1, 1, 23110, 'LEONILDO FERREIRA', 'LEONILDO', '30020', '1983-03-16', 'M'),
(2, 2, 23098, 'KLEVERLAND SOUSA', 'KLEVERLAND ', '23499', '1985-12-12', 'M'),
(3, 3, 12345, 'FAUSTO SAMPAIO', 'FAUSTO', '54321', '1987-11-14', 'M');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(20) NOT NULL,
  `senha` varchar(8) NOT NULL,
  `id_policial` int(11) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `fk_pol` (`id_policial`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `usuario`, `senha`, `id_policial`) VALUES
(1, 'fausto', '123456', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `vitima`
--

CREATE TABLE IF NOT EXISTS `vitima` (
  `id_vitima` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `telefone` varchar(10) NOT NULL,
  `data_nasc` date NOT NULL,
  `sexo` char(1) NOT NULL,
  `id_end` int(11) NOT NULL,
  PRIMARY KEY (`id_vitima`),
  KEY `fk_end` (`id_end`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `vitima`
--

INSERT INTO `vitima` (`id_vitima`, `nome`, `telefone`, `data_nasc`, `sexo`, `id_end`) VALUES
(1, 'ANA MARIA SILVA', '2222-3333', '1987-11-14', 'F', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `vtr`
--

CREATE TABLE IF NOT EXISTS `vtr` (
  `id_vtr` int(11) NOT NULL AUTO_INCREMENT,
  `prefixo` int(11) NOT NULL,
  `id_area` int(11) NOT NULL,
  PRIMARY KEY (`id_vtr`),
  KEY `area_fkvtr` (`id_area`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `vtr`
--

INSERT INTO `vtr` (`id_vtr`, `prefixo`, `id_area`) VALUES
(1, 1155, 1),
(2, 1156, 2),
(3, 1157, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `vtr_manutencao`
--

CREATE TABLE IF NOT EXISTS `vtr_manutencao` (
  `id_vtr` int(11) NOT NULL,
  `id_man` int(11) NOT NULL,
  `data` date NOT NULL,
  `descricao` text NOT NULL,
  KEY `fk_man` (`id_man`),
  KEY `fk_vtr` (`id_vtr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura stand-in para visualizar `vw_acusado_oco`
--
CREATE TABLE IF NOT EXISTS `vw_acusado_oco` (
`id_acusado` int(11)
,`nome` varchar(255)
,`telefone` varchar(10)
,`genitora` varchar(50)
,`data_nasc` date
,`caracteristicas` text
,`sexo` char(1)
,`id_endereco` int(11)
,`rua` varchar(255)
,`numero` varchar(10)
,`id_bairro` int(11)
,`bairro` varchar(50)
,`id_muni` int(11)
,`municipio` varchar(100)
,`id_ocorrencia` int(11)
,`data` date
,`horario` varchar(5)
,`narracao` text
);
-- --------------------------------------------------------

--
-- Estrutura stand-in para visualizar `vw_policial_oco`
--
CREATE TABLE IF NOT EXISTS `vw_policial_oco` (
`id_policial` int(11)
,`nome` varchar(100)
,`nome_guerra` varchar(50)
,`numeral` int(11)
,`matricula` varchar(12)
,`id_grad` int(11)
,`graduacao` varchar(20)
,`data_nasc` date
,`sexo` char(1)
,`id_ocorrencia` int(11)
,`data` date
,`horario` varchar(5)
,`narracao` text
);
-- --------------------------------------------------------

--
-- Estrutura stand-in para visualizar `vw_vitima_oco`
--
CREATE TABLE IF NOT EXISTS `vw_vitima_oco` (
`id_vitima` int(11)
,`nome` varchar(255)
,`telefone` varchar(10)
,`data_nasc` date
,`sexo` char(1)
,`id_endereco` int(11)
,`rua` varchar(255)
,`numero` varchar(10)
,`id_bairro` int(11)
,`bairro` varchar(50)
,`id_muni` int(11)
,`municipio` varchar(100)
,`id_ocorrencia` int(11)
,`data` date
,`horario` varchar(5)
,`narracao` text
);
-- --------------------------------------------------------

--
-- Estrutura para visualizar `vw_acusado_oco`
--
DROP TABLE IF EXISTS `vw_acusado_oco`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_acusado_oco` AS select `a`.`id_acusado` AS `id_acusado`,`a`.`nome` AS `nome`,`a`.`telefone` AS `telefone`,`a`.`genitora` AS `genitora`,`a`.`data_nasc` AS `data_nasc`,`a`.`caracteristicas` AS `caracteristicas`,`a`.`sexo` AS `sexo`,`e`.`id_endereco` AS `id_endereco`,`e`.`rua` AS `rua`,`e`.`numero` AS `numero`,`b`.`id_bairro` AS `id_bairro`,`b`.`bairro` AS `bairro`,`m`.`id_muni` AS `id_muni`,`m`.`municipio` AS `municipio`,`o`.`id_ocorrencia` AS `id_ocorrencia`,`o`.`data` AS `data`,`o`.`horario` AS `horario`,`o`.`narracao` AS `narracao` from (((((`ocorrencia_acusado` `oa` join `acusado` `a` on((`oa`.`id_acusado` = `a`.`id_acusado`))) join `ocorrencia` `o` on((`oa`.`id_ocorrencia` = `o`.`id_ocorrencia`))) left join `endereco` `e` on((`a`.`id_end` = `e`.`id_endereco`))) left join `bairro` `b` on((`e`.`id_bairro` = `b`.`id_bairro`))) left join `municipio` `m` on((`b`.`id_muni` = `m`.`id_muni`))) order by `o`.`data` desc;

-- --------------------------------------------------------

--
-- Estrutura para visualizar `vw_policial_oco`
--
DROP TABLE IF EXISTS `vw_policial_oco`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_policial_oco` AS select `p`.`id_policial` AS `id_policial`,`p`.`nome` AS `nome`,`p`.`nome_guerra` AS `nome_guerra`,`p`.`numeral` AS `numeral`,`p`.`matricula` AS `matricula`,`g`.`id_grad` AS `id_grad`,`g`.`graduacao` AS `graduacao`,`p`.`data_nasc` AS `data_nasc`,`p`.`sexo` AS `sexo`,`o`.`id_ocorrencia` AS `id_ocorrencia`,`o`.`data` AS `data`,`o`.`horario` AS `horario`,`o`.`narracao` AS `narracao` from (((`ocorrencia_policial` `op` join `policial` `p` on((`op`.`id_policial` = `p`.`id_policial`))) join `graduacao` `g` on((`p`.`id_graduacao` = `g`.`id_grad`))) join `ocorrencia` `o` on((`op`.`id_ocorrencia` = `o`.`id_ocorrencia`))) order by `o`.`data` desc;

-- --------------------------------------------------------

--
-- Estrutura para visualizar `vw_vitima_oco`
--
DROP TABLE IF EXISTS `vw_vitima_oco`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_vitima_oco` AS select `v`.`id_vitima` AS `id_vitima`,`v`.`nome` AS `nome`,`v`.`telefone` AS `telefone`,`v`.`data_nasc` AS `data_nasc`,`v`.`sexo` AS `sexo`,`e`.`id_endereco` AS `id_endereco`,`e`.`rua` AS `rua`,`e`.`numero` AS `numero`,`b`.`id_bairro` AS `id_bairro`,`b`.`bairro` AS `bairro`,`m`.`id_muni` AS `id_muni`,`m`.`municipio` AS `municipio`,`o`.`id_ocorrencia` AS `id_ocorrencia`,`o`.`data` AS `data`,`o`.`horario` AS `horario`,`o`.`narracao` AS `narracao` from (((((`ocorrencia_vitima` `ov` join `vitima` `v` on((`ov`.`id_vitima` = `v`.`id_vitima`))) join `ocorrencia` `o` on((`ov`.`id_ocorrencia` = `o`.`id_ocorrencia`))) left join `endereco` `e` on((`v`.`id_end` = `e`.`id_endereco`))) left join `bairro` `b` on((`e`.`id_bairro` = `b`.`id_bairro`))) left join `municipio` `m` on((`b`.`id_muni` = `m`.`id_muni`))) order by `o`.`data` desc;

--
-- Restrições para as tabelas dumpadas
--

--
-- Restrições para a tabela `acusado`
--
ALTER TABLE `acusado`
  ADD CONSTRAINT `fk_end2` FOREIGN KEY (`id_end`) REFERENCES `endereco` (`id_endereco`) ON UPDATE CASCADE;

--
-- Restrições para a tabela `ap_arma`
--
ALTER TABLE `ap_arma`
  ADD CONSTRAINT `fk_arma` FOREIGN KEY (`id_arma`) REFERENCES `arma` (`id_arma`),
  ADD CONSTRAINT `fk_ap_arma_ocorrencia_crime1` FOREIGN KEY (`id_ocorrencia`, `id_crime`) REFERENCES `ocorrencia_crime` (`id_ocorrencia`, `id_crime`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `ap_carro`
--
ALTER TABLE `ap_carro`
  ADD CONSTRAINT `fk_ap_carro_ocorrencia_crime1` FOREIGN KEY (`id_ocorrencia`, `id_crime`) REFERENCES `ocorrencia_crime` (`id_ocorrencia`, `id_crime`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `ap_droga`
--
ALTER TABLE `ap_droga`
  ADD CONSTRAINT `fk_droga` FOREIGN KEY (`id_droga`) REFERENCES `droga` (`id_droga`),
  ADD CONSTRAINT `fk_ap_droga_ocorrencia_crime1` FOREIGN KEY (`id_ocorrencia`, `id_crime`) REFERENCES `ocorrencia_crime` (`id_ocorrencia`, `id_crime`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `area`
--
ALTER TABLE `area`
  ADD CONSTRAINT `muni` FOREIGN KEY (`id_muni`) REFERENCES `municipio` (`id_muni`) ON UPDATE CASCADE;

--
-- Restrições para a tabela `bairro`
--
ALTER TABLE `bairro`
  ADD CONSTRAINT `area_fk` FOREIGN KEY (`id_area`) REFERENCES `area` (`id_area`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bairro_muni` FOREIGN KEY (`id_muni`) REFERENCES `municipio` (`id_muni`);

--
-- Restrições para a tabela `endereco`
--
ALTER TABLE `endereco`
  ADD CONSTRAINT `fk_bairro` FOREIGN KEY (`id_bairro`) REFERENCES `bairro` (`id_bairro`) ON UPDATE CASCADE;

--
-- Restrições para a tabela `homicidio`
--
ALTER TABLE `homicidio`
  ADD CONSTRAINT `fk_homicidio_ocorrencia_crime1` FOREIGN KEY (`id_ocorrencia`, `id_crime`) REFERENCES `ocorrencia_crime` (`id_ocorrencia`, `id_crime`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `lesao`
--
ALTER TABLE `lesao`
  ADD CONSTRAINT `fk_lesao_ocorrencia_crime1` FOREIGN KEY (`id_ocorrencia`, `id_crime`) REFERENCES `ocorrencia_crime` (`id_ocorrencia`, `id_crime`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `ocorrencia`
--
ALTER TABLE `ocorrencia`
  ADD CONSTRAINT `fk_end_oco` FOREIGN KEY (`id_end`) REFERENCES `endereco` (`id_endereco`),
  ADD CONSTRAINT `fk_vtr_oco` FOREIGN KEY (`id_vtr`) REFERENCES `vtr` (`id_vtr`),
  ADD CONSTRAINT `fk_area_oco` FOREIGN KEY (`id_area`) REFERENCES `area` (`id_area`),
  ADD CONSTRAINT `fk_usuario_oco` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Restrições para a tabela `ocorrencia_acusado`
--
ALTER TABLE `ocorrencia_acusado`
  ADD CONSTRAINT `fk_ocorrencia_has_acusado_ocorrencia1` FOREIGN KEY (`id_ocorrencia`) REFERENCES `ocorrencia` (`id_ocorrencia`),
  ADD CONSTRAINT `fk_ocorrencia_has_acusado_acusado1` FOREIGN KEY (`id_acusado`) REFERENCES `acusado` (`id_acusado`);

--
-- Restrições para a tabela `ocorrencia_crime`
--
ALTER TABLE `ocorrencia_crime`
  ADD CONSTRAINT `fk_ocorrencia_has_crime_ocorrencia1` FOREIGN KEY (`id_ocorrencia`) REFERENCES `ocorrencia` (`id_ocorrencia`),
  ADD CONSTRAINT `fk_ocorrencia_has_crime_crime1` FOREIGN KEY (`id_crime`) REFERENCES `crime` (`id_crime`);

--
-- Restrições para a tabela `ocorrencia_policial`
--
ALTER TABLE `ocorrencia_policial`
  ADD CONSTRAINT `fk_ocorrencia_has_policial_ocorrencia1` FOREIGN KEY (`id_ocorrencia`) REFERENCES `ocorrencia` (`id_ocorrencia`),
  ADD CONSTRAINT `fk_ocorrencia_has_policial_policial1` FOREIGN KEY (`id_policial`) REFERENCES `policial` (`id_policial`);

--
-- Restrições para a tabela `ocorrencia_vitima`
--
ALTER TABLE `ocorrencia_vitima`
  ADD CONSTRAINT `fk_oco` FOREIGN KEY (`id_ocorrencia`) REFERENCES `ocorrencia` (`id_ocorrencia`),
  ADD CONSTRAINT `fk_vit` FOREIGN KEY (`id_vitima`) REFERENCES `vitima` (`id_vitima`);

--
-- Restrições para a tabela `policial`
--
ALTER TABLE `policial`
  ADD CONSTRAINT `grad2` FOREIGN KEY (`id_graduacao`) REFERENCES `graduacao` (`id_grad`) ON UPDATE CASCADE;

--
-- Restrições para a tabela `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_pol` FOREIGN KEY (`id_policial`) REFERENCES `policial` (`id_policial`);

--
-- Restrições para a tabela `vitima`
--
ALTER TABLE `vitima`
  ADD CONSTRAINT `fk_end` FOREIGN KEY (`id_end`) REFERENCES `endereco` (`id_endereco`) ON UPDATE CASCADE;

--
-- Restrições para a tabela `vtr`
--
ALTER TABLE `vtr`
  ADD CONSTRAINT `area_fkvtr` FOREIGN KEY (`id_area`) REFERENCES `area` (`id_area`) ON UPDATE CASCADE;

--
-- Restrições para a tabela `vtr_manutencao`
--
ALTER TABLE `vtr_manutencao`
  ADD CONSTRAINT `fk_man` FOREIGN KEY (`id_man`) REFERENCES `manutencao` (`id_man`),
  ADD CONSTRAINT `fk_vtr` FOREIGN KEY (`id_vtr`) REFERENCES `vtr` (`id_vtr`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
