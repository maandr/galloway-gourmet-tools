CREATE TABLE IF NOT EXISTS `gg_pricing-tool-labels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `desc` varchar(128) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `priceKg` decimal(10,2) NOT NULL,
  `volume` decimal(10,0) NOT NULL,
  `nameOnly` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=UTF-8 AUTO_INCREMENT=1;
