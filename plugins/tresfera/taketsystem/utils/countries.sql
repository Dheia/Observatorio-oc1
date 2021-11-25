--
-- Table structure for table `country_t`
--

CREATE TABLE IF NOT EXISTS `country_t` (
  `country_id` int(5) NOT NULL AUTO_INCREMENT,
  `iso2` char(2) DEFAULT NULL,
  `short_name` varchar(80) NOT NULL DEFAULT '',
  `long_name` varchar(80) NOT NULL DEFAULT '',
  `iso3` char(3) DEFAULT NULL,
  `numcode` varchar(6) DEFAULT NULL,
  `un_member` varchar(12) DEFAULT NULL,
  `calling_code` varchar(8) DEFAULT NULL,
  `cctld` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=251 ;

--
-- Dumping data for table `country_t`
--

INSERT INTO `country_t` (`country_id`, `iso2`, `short_name`, `long_name`, `iso3`, `numcode`, `un_member`, `calling_code`, `cctld`) VALUES
(1, 'AF', 'Afghanistan', 'Islamic Republic of Afghanistan', 'AFG', '004', 'yes', '93', '.af'),
(2, 'AX', 'Aland Islands', '&Aring;land Islands', 'ALA', '248', 'no', '358', '.ax'),
(3, 'AL', 'Albania', 'Republic of Albania', 'ALB', '008', 'yes', '355', '.al'),
(4, 'DZ', 'Algeria', 'People''s Democratic Republic of Algeria', 'DZA', '012', 'yes', '213', '.dz'),
(5, 'AS', 'American Samoa', 'American Samoa', 'ASM', '016', 'no', '1+684', '.as'),
(6, 'AD', 'Andorra', 'Principality of Andorra', 'AND', '020', 'yes', '376', '.ad'),
(7, 'AO', 'Angola', 'Republic of Angola', 'AGO', '024', 'yes', '244', '.ao'),
(8, 'AI', 'Anguilla', 'Anguilla', 'AIA', '660', 'no', '1+264', '.ai'),
(9, 'AQ', 'Antarctica', 'Antarctica', 'ATA', '010', 'no', '672', '.aq'),
(10, 'AG', 'Antigua and Barbuda', 'Antigua and Barbuda', 'ATG', '028', 'yes', '1+268', '.ag'),
(11, 'AR', 'Argentina', 'Argentine Republic', 'ARG', '032', 'yes', '54', '.ar'),
(12, 'AM', 'Armenia', 'Republic of Armenia', 'ARM', '051', 'yes', '374', '.am'),
(13, 'AW', 'Aruba', 'Aruba', 'ABW', '533', 'no', '297', '.aw'),
(14, 'AU', 'Australia', 'Commonwealth of Australia', 'AUS', '036', 'yes', '61', '.au'),
(15, 'AT', 'Austria', 'Republic of Austria', 'AUT', '040', 'yes', '43', '.at'),
(16, 'AZ', 'Azerbaijan', 'Republic of Azerbaijan', 'AZE', '031', 'yes', '994', '.az'),
(17, 'BS', 'Bahamas', 'Commonwealth of The Bahamas', 'BHS', '044', 'yes', '1+242', '.bs'),
(18, 'BH', 'Bahrain', 'Kingdom of Bahrain', 'BHR', '048', 'yes', '973', '.bh'),
(19, 'BD', 'Bangladesh', 'People''s Republic of Bangladesh', 'BGD', '050', 'yes', '880', '.bd'),
(20, 'BB', 'Barbados', 'Barbados', 'BRB', '052', 'yes', '1+246', '.bb'),
(21, 'BY', 'Belarus', 'Republic of Belarus', 'BLR', '112', 'yes', '375', '.by'),
(22, 'BE', 'Belgium', 'Kingdom of Belgium', 'BEL', '056', 'yes', '32', '.be'),
(23, 'BZ', 'Belize', 'Belize', 'BLZ', '084', 'yes', '501', '.bz'),
(24, 'BJ', 'Benin', 'Republic of Benin', 'BEN', '204', 'yes', '229', '.bj'),
(25, 'BM', 'Bermuda', 'Bermuda Islands', 'BMU', '060', 'no', '1+441', '.bm'),
(26, 'BT', 'Bhutan', 'Kingdom of Bhutan', 'BTN', '064', 'yes', '975', '.bt'),
(27, 'BO', 'Bolivia', 'Plurinational State of Bolivia', 'BOL', '068', 'yes', '591', '.bo'),
(28, 'BQ', 'Bonaire, Sint Eustatius and Saba', 'Bonaire, Sint Eustatius and Saba', 'BES', '535', 'no', '599', '.bq'),
(29, 'BA', 'Bosnia and Herzegovina', 'Bosnia and Herzegovina', 'BIH', '070', 'yes', '387', '.ba'),
(30, 'BW', 'Botswana', 'Republic of Botswana', 'BWA', '072', 'yes', '267', '.bw'),
(31, 'BV', 'Bouvet Island', 'Bouvet Island', 'BVT', '074', 'no', 'NONE', '.bv'),
(32, 'BR', 'Brazil', 'Federative Republic of Brazil', 'BRA', '076', 'yes', '55', '.br'),
(33, 'IO', 'British Indian Ocean Territory', 'British Indian Ocean Territory', 'IOT', '086', 'no', '246', '.io'),
(34, 'BN', 'Brunei', 'Brunei Darussalam', 'BRN', '096', 'yes', '673', '.bn'),
(35, 'BG', 'Bulgaria', 'Republic of Bulgaria', 'BGR', '100', 'yes', '359', '.bg'),
(36, 'BF', 'Burkina Faso', 'Burkina Faso', 'BFA', '854', 'yes', '226', '.bf'),
(37, 'BI', 'Burundi', 'Republic of Burundi', 'BDI', '108', 'yes', '257', '.bi'),
(38, 'KH', 'Cambodia', 'Kingdom of Cambodia', 'KHM', '116', 'yes', '855', '.kh'),
(39, 'CM', 'Cameroon', 'Republic of Cameroon', 'CMR', '120', 'yes', '237', '.cm'),
(40, 'CA', 'Canada', 'Canada', 'CAN', '124', 'yes', '1', '.ca'),
(41, 'CV', 'Cape Verde', 'Republic of Cape Verde', 'CPV', '132', 'yes', '238', '.cv'),
(42, 'KY', 'Cayman Islands', 'The Cayman Islands', 'CYM', '136', 'no', '1+345', '.ky'),
(43, 'CF', 'Central African Republic', 'Central African Republic', 'CAF', '140', 'yes', '236', '.cf'),
(44, 'TD', 'Chad', 'Republic of Chad', 'TCD', '148', 'yes', '235', '.td'),
(45, 'CL', 'Chile', 'Republic of Chile', 'CHL', '152', 'yes', '56', '.cl'),
(46, 'CN', 'China', 'People''s Republic of China', 'CHN', '156', 'yes', '86', '.cn'),
(47, 'CX', 'Christmas Island', 'Christmas Island', 'CXR', '162', 'no', '61', '.cx'),
(48, 'CC', 'Cocos (Keeling) Islands', 'Cocos (Keeling) Islands', 'CCK', '166', 'no', '61', '.cc'),
(49, 'CO', 'Colombia', 'Republic of Colombia', 'COL', '170', 'yes', '57', '.co'),
(50, 'KM', 'Comoros', 'Union of the Comoros', 'COM', '174', 'yes', '269', '.km'),
(51, 'CG', 'Congo', 'Republic of the Congo', 'COG', '178', 'yes', '242', '.cg'),
(52, 'CK', 'Cook Islands', 'Cook Islands', 'COK', '184', 'some', '682', '.ck'),
(53, 'CR', 'Costa Rica', 'Republic of Costa Rica', 'CRI', '188', 'yes', '506', '.cr'),
(54, 'CI', 'Cote d''ivoire (Ivory Coast)', 'Republic of C&ocirc;te D''Ivoire (Ivory Coast)', 'CIV', '384', 'yes', '225', '.ci'),
(55, 'HR', 'Croatia', 'Republic of Croatia', 'HRV', '191', 'yes', '385', '.hr'),
(56, 'CU', 'Cuba', 'Republic of Cuba', 'CUB', '192', 'yes', '53', '.cu'),
(57, 'CW', 'Curacao', 'Cura&ccedil;ao', 'CUW', '531', 'no', '599', '.cw'),
(58, 'CY', 'Cyprus', 'Republic of Cyprus', 'CYP', '196', 'yes', '357', '.cy'),
(59, 'CZ', 'Czech Republic', 'Czech Republic', 'CZE', '203', 'yes', '420', '.cz'),
(60, 'CD', 'Democratic Republic of the Congo', 'Democratic Republic of the Congo', 'COD', '180', 'yes', '243', '.cd'),
(61, 'DK', 'Denmark', 'Kingdom of Denmark', 'DNK', '208', 'yes', '45', '.dk'),
(62, 'DJ', 'Djibouti', 'Republic of Djibouti', 'DJI', '262', 'yes', '253', '.dj'),
(63, 'DM', 'Dominica', 'Commonwealth of Dominica', 'DMA', '212', 'yes', '1+767', '.dm'),
(64, 'DO', 'Dominican Republic', 'Dominican Republic', 'DOM', '214', 'yes', '1+809, 8', '.do'),
(65, 'EC', 'Ecuador', 'Republic of Ecuador', 'ECU', '218', 'yes', '593', '.ec'),
(66, 'EG', 'Egypt', 'Arab Republic of Egypt', 'EGY', '818', 'yes', '20', '.eg'),
(67, 'SV', 'El Salvador', 'Republic of El Salvador', 'SLV', '222', 'yes', '503', '.sv'),
(68, 'GQ', 'Equatorial Guinea', 'Republic of Equatorial Guinea', 'GNQ', '226', 'yes', '240', '.gq'),
(69, 'ER', 'Eritrea', 'State of Eritrea', 'ERI', '232', 'yes', '291', '.er'),
(70, 'EE', 'Estonia', 'Republic of Estonia', 'EST', '233', 'yes', '372', '.ee'),
(71, 'ET', 'Ethiopia', 'Federal Democratic Republic of Ethiopia', 'ETH', '231', 'yes', '251', '.et'),
(72, 'FK', 'Falkland Islands (Malvinas)', 'The Falkland Islands (Malvinas)', 'FLK', '238', 'no', '500', '.fk'),
(73, 'FO', 'Faroe Islands', 'The Faroe Islands', 'FRO', '234', 'no', '298', '.fo'),
(74, 'FJ', 'Fiji', 'Republic of Fiji', 'FJI', '242', 'yes', '679', '.fj'),
(75, 'FI', 'Finland', 'Republic of Finland', 'FIN', '246', 'yes', '358', '.fi'),
(76, 'FR', 'France', 'French Republic', 'FRA', '250', 'yes', '33', '.fr'),
(77, 'GF', 'French Guiana', 'French Guiana', 'GUF', '254', 'no', '594', '.gf'),
(78, 'PF', 'French Polynesia', 'French Polynesia', 'PYF', '258', 'no', '689', '.pf'),
(79, 'TF', 'French Southern Territories', 'French Southern Territories', 'ATF', '260', 'no', NULL, '.tf'),
(80, 'GA', 'Gabon', 'Gabonese Republic', 'GAB', '266', 'yes', '241', '.ga'),
(81, 'GM', 'Gambia', 'Republic of The Gambia', 'GMB', '270', 'yes', '220', '.gm'),
(82, 'GE', 'Georgia', 'Georgia', 'GEO', '268', 'yes', '995', '.ge'),
(83, 'DE', 'Germany', 'Federal Republic of Germany', 'DEU', '276', 'yes', '49', '.de'),
(84, 'GH', 'Ghana', 'Republic of Ghana', 'GHA', '288', 'yes', '233', '.gh'),
(85, 'GI', 'Gibraltar', 'Gibraltar', 'GIB', '292', 'no', '350', '.gi'),
(86, 'GR', 'Greece', 'Hellenic Republic', 'GRC', '300', 'yes', '30', '.gr'),
(87, 'GL', 'Greenland', 'Greenland', 'GRL', '304', 'no', '299', '.gl'),
(88, 'GD', 'Grenada', 'Grenada', 'GRD', '308', 'yes', '1+473', '.gd'),
(89, 'GP', 'Guadaloupe', 'Guadeloupe', 'GLP', '312', 'no', '590', '.gp'),
(90, 'GU', 'Guam', 'Guam', 'GUM', '316', 'no', '1+671', '.gu'),
(91, 'GT', 'Guatemala', 'Republic of Guatemala', 'GTM', '320', 'yes', '502', '.gt'),
(92, 'GG', 'Guernsey', 'Guernsey', 'GGY', '831', 'no', '44', '.gg'),
(93, 'GN', 'Guinea', 'Republic of Guinea', 'GIN', '324', 'yes', '224', '.gn'),
(94, 'GW', 'Guinea-Bissau', 'Republic of Guinea-Bissau', 'GNB', '624', 'yes', '245', '.gw'),
(95, 'GY', 'Guyana', 'Co-operative Republic of Guyana', 'GUY', '328', 'yes', '592', '.gy'),
(96, 'HT', 'Haiti', 'Republic of Haiti', 'HTI', '332', 'yes', '509', '.ht'),
(97, 'HM', 'Heard Island and McDonald Islands', 'Heard Island and McDonald Islands', 'HMD', '334', 'no', 'NONE', '.hm'),
(98, 'HN', 'Honduras', 'Republic of Honduras', 'HND', '340', 'yes', '504', '.hn'),
(99, 'HK', 'Hong Kong', 'Hong Kong', 'HKG', '344', 'no', '852', '.hk'),
(100, 'HU', 'Hungary', 'Hungary', 'HUN', '348', 'yes', '36', '.hu'),
(101, 'IS', 'Iceland', 'Republic of Iceland', 'ISL', '352', 'yes', '354', '.is'),
(102, 'IN', 'India', 'Republic of India', 'IND', '356', 'yes', '91', '.in'),
(103, 'ID', 'Indonesia', 'Republic of Indonesia', 'IDN', '360', 'yes', '62', '.id'),
(104, 'IR', 'Iran', 'Islamic Republic of Iran', 'IRN', '364', 'yes', '98', '.ir'),
(105, 'IQ', 'Iraq', 'Republic of Iraq', 'IRQ', '368', 'yes', '964', '.iq'),
(106, 'IE', 'Ireland', 'Ireland', 'IRL', '372', 'yes', '353', '.ie'),
(107, 'IM', 'Isle of Man', 'Isle of Man', 'IMN', '833', 'no', '44', '.im'),
(108, 'IL', 'Israel', 'State of Israel', 'ISR', '376', 'yes', '972', '.il'),
(109, 'IT', 'Italy', 'Italian Republic', 'ITA', '380', 'yes', '39', '.jm'),
(110, 'JM', 'Jamaica', 'Jamaica', 'JAM', '388', 'yes', '1+876', '.jm'),
(111, 'JP', 'Japan', 'Japan', 'JPN', '392', 'yes', '81', '.jp'),
(112, 'JE', 'Jersey', 'The Bailiwick of Jersey', 'JEY', '832', 'no', '44', '.je'),
(113, 'JO', 'Jordan', 'Hashemite Kingdom of Jordan', 'JOR', '400', 'yes', '962', '.jo'),
(114, 'KZ', 'Kazakhstan', 'Republic of Kazakhstan', 'KAZ', '398', 'yes', '7', '.kz'),
(115, 'KE', 'Kenya', 'Republic of Kenya', 'KEN', '404', 'yes', '254', '.ke'),
(116, 'KI', 'Kiribati', 'Republic of Kiribati', 'KIR', '296', 'yes', '686', '.ki'),
(117, 'XK', 'Kosovo', 'Republic of Kosovo', '---', '---', 'some', '381', ''),
(118, 'KW', 'Kuwait', 'State of Kuwait', 'KWT', '414', 'yes', '965', '.kw'),
(119, 'KG', 'Kyrgyzstan', 'Kyrgyz Republic', 'KGZ', '417', 'yes', '996', '.kg'),
(120, 'LA', 'Laos', 'Lao People''s Democratic Republic', 'LAO', '418', 'yes', '856', '.la'),
(121, 'LV', 'Latvia', 'Republic of Latvia', 'LVA', '428', 'yes', '371', '.lv'),
(122, 'LB', 'Lebanon', 'Republic of Lebanon', 'LBN', '422', 'yes', '961', '.lb'),
(123, 'LS', 'Lesotho', 'Kingdom of Lesotho', 'LSO', '426', 'yes', '266', '.ls'),
(124, 'LR', 'Liberia', 'Republic of Liberia', 'LBR', '430', 'yes', '231', '.lr'),
(125, 'LY', 'Libya', 'Libya', 'LBY', '434', 'yes', '218', '.ly'),
(126, 'LI', 'Liechtenstein', 'Principality of Liechtenstein', 'LIE', '438', 'yes', '423', '.li'),
(127, 'LT', 'Lithuania', 'Republic of Lithuania', 'LTU', '440', 'yes', '370', '.lt'),
(128, 'LU', 'Luxembourg', 'Grand Duchy of Luxembourg', 'LUX', '442', 'yes', '352', '.lu'),
(129, 'MO', 'Macao', 'The Macao Special Administrative Region', 'MAC', '446', 'no', '853', '.mo'),
(130, 'MK', 'Macedonia', 'The Former Yugoslav Republic of Macedonia', 'MKD', '807', 'yes', '389', '.mk'),
(131, 'MG', 'Madagascar', 'Republic of Madagascar', 'MDG', '450', 'yes', '261', '.mg'),
(132, 'MW', 'Malawi', 'Republic of Malawi', 'MWI', '454', 'yes', '265', '.mw'),
(133, 'MY', 'Malaysia', 'Malaysia', 'MYS', '458', 'yes', '60', '.my'),
(134, 'MV', 'Maldives', 'Republic of Maldives', 'MDV', '462', 'yes', '960', '.mv'),
(135, 'ML', 'Mali', 'Republic of Mali', 'MLI', '466', 'yes', '223', '.ml'),
(136, 'MT', 'Malta', 'Republic of Malta', 'MLT', '470', 'yes', '356', '.mt'),
(137, 'MH', 'Marshall Islands', 'Republic of the Marshall Islands', 'MHL', '584', 'yes', '692', '.mh'),
(138, 'MQ', 'Martinique', 'Martinique', 'MTQ', '474', 'no', '596', '.mq'),
(139, 'MR', 'Mauritania', 'Islamic Republic of Mauritania', 'MRT', '478', 'yes', '222', '.mr'),
(140, 'MU', 'Mauritius', 'Republic of Mauritius', 'MUS', '480', 'yes', '230', '.mu'),
(141, 'YT', 'Mayotte', 'Mayotte', 'MYT', '175', 'no', '262', '.yt'),
(142, 'MX', 'Mexico', 'United Mexican States', 'MEX', '484', 'yes', '52', '.mx'),
(143, 'FM', 'Micronesia', 'Federated States of Micronesia', 'FSM', '583', 'yes', '691', '.fm'),
(144, 'MD', 'Moldava', 'Republic of Moldova', 'MDA', '498', 'yes', '373', '.md'),
(145, 'MC', 'Monaco', 'Principality of Monaco', 'MCO', '492', 'yes', '377', '.mc'),
(146, 'MN', 'Mongolia', 'Mongolia', 'MNG', '496', 'yes', '976', '.mn'),
(147, 'ME', 'Montenegro', 'Montenegro', 'MNE', '499', 'yes', '382', '.me'),
(148, 'MS', 'Montserrat', 'Montserrat', 'MSR', '500', 'no', '1+664', '.ms'),
(149, 'MA', 'Morocco', 'Kingdom of Morocco', 'MAR', '504', 'yes', '212', '.ma'),
(150, 'MZ', 'Mozambique', 'Republic of Mozambique', 'MOZ', '508', 'yes', '258', '.mz'),
(151, 'MM', 'Myanmar (Burma)', 'Republic of the Union of Myanmar', 'MMR', '104', 'yes', '95', '.mm'),
(152, 'NA', 'Namibia', 'Republic of Namibia', 'NAM', '516', 'yes', '264', '.na'),
(153, 'NR', 'Nauru', 'Republic of Nauru', 'NRU', '520', 'yes', '674', '.nr'),
(154, 'NP', 'Nepal', 'Federal Democratic Republic of Nepal', 'NPL', '524', 'yes', '977', '.np'),
(155, 'NL', 'Netherlands', 'Kingdom of the Netherlands', 'NLD', '528', 'yes', '31', '.nl'),
(156, 'NC', 'New Caledonia', 'New Caledonia', 'NCL', '540', 'no', '687', '.nc'),
(157, 'NZ', 'New Zealand', 'New Zealand', 'NZL', '554', 'yes', '64', '.nz'),
(158, 'NI', 'Nicaragua', 'Republic of Nicaragua', 'NIC', '558', 'yes', '505', '.ni'),
(159, 'NE', 'Niger', 'Republic of Niger', 'NER', '562', 'yes', '227', '.ne'),
(160, 'NG', 'Nigeria', 'Federal Republic of Nigeria', 'NGA', '566', 'yes', '234', '.ng'),
(161, 'NU', 'Niue', 'Niue', 'NIU', '570', 'some', '683', '.nu'),
(162, 'NF', 'Norfolk Island', 'Norfolk Island', 'NFK', '574', 'no', '672', '.nf'),
(163, 'KP', 'North Korea', 'Democratic People''s Republic of Korea', 'PRK', '408', 'yes', '850', '.kp'),
(164, 'MP', 'Northern Mariana Islands', 'Northern Mariana Islands', 'MNP', '580', 'no', '1+670', '.mp'),
(165, 'NO', 'Norway', 'Kingdom of Norway', 'NOR', '578', 'yes', '47', '.no'),
(166, 'OM', 'Oman', 'Sultanate of Oman', 'OMN', '512', 'yes', '968', '.om'),
(167, 'PK', 'Pakistan', 'Islamic Republic of Pakistan', 'PAK', '586', 'yes', '92', '.pk'),
(168, 'PW', 'Palau', 'Republic of Palau', 'PLW', '585', 'yes', '680', '.pw'),
(169, 'PS', 'Palestine', 'State of Palestine (or Occupied Palestinian Territory)', 'PSE', '275', 'some', '970', '.ps'),
(170, 'PA', 'Panama', 'Republic of Panama', 'PAN', '591', 'yes', '507', '.pa'),
(171, 'PG', 'Papua New Guinea', 'Independent State of Papua New Guinea', 'PNG', '598', 'yes', '675', '.pg'),
(172, 'PY', 'Paraguay', 'Republic of Paraguay', 'PRY', '600', 'yes', '595', '.py'),
(173, 'PE', 'Peru', 'Republic of Peru', 'PER', '604', 'yes', '51', '.pe'),
(174, 'PH', 'Phillipines', 'Republic of the Philippines', 'PHL', '608', 'yes', '63', '.ph'),
(175, 'PN', 'Pitcairn', 'Pitcairn', 'PCN', '612', 'no', 'NONE', '.pn'),
(176, 'PL', 'Poland', 'Republic of Poland', 'POL', '616', 'yes', '48', '.pl'),
(177, 'PT', 'Portugal', 'Portuguese Republic', 'PRT', '620', 'yes', '351', '.pt'),
(178, 'PR', 'Puerto Rico', 'Commonwealth of Puerto Rico', 'PRI', '630', 'no', '1+939', '.pr'),
(179, 'QA', 'Qatar', 'State of Qatar', 'QAT', '634', 'yes', '974', '.qa'),
(180, 'RE', 'Reunion', 'R&eacute;union', 'REU', '638', 'no', '262', '.re'),
(181, 'RO', 'Romania', 'Romania', 'ROU', '642', 'yes', '40', '.ro'),
(182, 'RU', 'Russia', 'Russian Federation', 'RUS', '643', 'yes', '7', '.ru'),
(183, 'RW', 'Rwanda', 'Republic of Rwanda', 'RWA', '646', 'yes', '250', '.rw'),
(184, 'BL', 'Saint Barthelemy', 'Saint Barth&eacute;lemy', 'BLM', '652', 'no', '590', '.bl'),
(185, 'SH', 'Saint Helena', 'Saint Helena, Ascension and Tristan da Cunha', 'SHN', '654', 'no', '290', '.sh'),
(186, 'KN', 'Saint Kitts and Nevis', 'Federation of Saint Christopher and Nevis', 'KNA', '659', 'yes', '1+869', '.kn'),
(187, 'LC', 'Saint Lucia', 'Saint Lucia', 'LCA', '662', 'yes', '1+758', '.lc'),
(188, 'MF', 'Saint Martin', 'Saint Martin', 'MAF', '663', 'no', '590', '.mf'),
(189, 'PM', 'Saint Pierre and Miquelon', 'Saint Pierre and Miquelon', 'SPM', '666', 'no', '508', '.pm'),
(190, 'VC', 'Saint Vincent and the Grenadines', 'Saint Vincent and the Grenadines', 'VCT', '670', 'yes', '1+784', '.vc'),
(191, 'WS', 'Samoa', 'Independent State of Samoa', 'WSM', '882', 'yes', '685', '.ws'),
(192, 'SM', 'San Marino', 'Republic of San Marino', 'SMR', '674', 'yes', '378', '.sm'),
(193, 'ST', 'Sao Tome and Principe', 'Democratic Republic of S&atilde;o Tom&eacute; and Pr&iacute;ncipe', 'STP', '678', 'yes', '239', '.st'),
(194, 'SA', 'Saudi Arabia', 'Kingdom of Saudi Arabia', 'SAU', '682', 'yes', '966', '.sa'),
(195, 'SN', 'Senegal', 'Republic of Senegal', 'SEN', '686', 'yes', '221', '.sn'),
(196, 'RS', 'Serbia', 'Republic of Serbia', 'SRB', '688', 'yes', '381', '.rs'),
(197, 'SC', 'Seychelles', 'Republic of Seychelles', 'SYC', '690', 'yes', '248', '.sc'),
(198, 'SL', 'Sierra Leone', 'Republic of Sierra Leone', 'SLE', '694', 'yes', '232', '.sl'),
(199, 'SG', 'Singapore', 'Republic of Singapore', 'SGP', '702', 'yes', '65', '.sg'),
(200, 'SX', 'Sint Maarten', 'Sint Maarten', 'SXM', '534', 'no', '1+721', '.sx'),
(201, 'SK', 'Slovakia', 'Slovak Republic', 'SVK', '703', 'yes', '421', '.sk'),
(202, 'SI', 'Slovenia', 'Republic of Slovenia', 'SVN', '705', 'yes', '386', '.si'),
(203, 'SB', 'Solomon Islands', 'Solomon Islands', 'SLB', '090', 'yes', '677', '.sb'),
(204, 'SO', 'Somalia', 'Somali Republic', 'SOM', '706', 'yes', '252', '.so'),
(205, 'ZA', 'South Africa', 'Republic of South Africa', 'ZAF', '710', 'yes', '27', '.za'),
(206, 'GS', 'South Georgia and the South Sandwich Islands', 'South Georgia and the South Sandwich Islands', 'SGS', '239', 'no', '500', '.gs'),
(207, 'KR', 'South Korea', 'Republic of Korea', 'KOR', '410', 'yes', '82', '.kr'),
(208, 'SS', 'South Sudan', 'Republic of South Sudan', 'SSD', '728', 'yes', '211', '.ss'),
(209, 'ES', 'Spain', 'Kingdom of Spain', 'ESP', '724', 'yes', '34', '.es'),
(210, 'LK', 'Sri Lanka', 'Democratic Socialist Republic of Sri Lanka', 'LKA', '144', 'yes', '94', '.lk'),
(211, 'SD', 'Sudan', 'Republic of the Sudan', 'SDN', '729', 'yes', '249', '.sd'),
(212, 'SR', 'Suriname', 'Republic of Suriname', 'SUR', '740', 'yes', '597', '.sr'),
(213, 'SJ', 'Svalbard and Jan Mayen', 'Svalbard and Jan Mayen', 'SJM', '744', 'no', '47', '.sj'),
(214, 'SZ', 'Swaziland', 'Kingdom of Swaziland', 'SWZ', '748', 'yes', '268', '.sz'),
(215, 'SE', 'Sweden', 'Kingdom of Sweden', 'SWE', '752', 'yes', '46', '.se'),
(216, 'CH', 'Switzerland', 'Swiss Confederation', 'CHE', '756', 'yes', '41', '.ch'),
(217, 'SY', 'Syria', 'Syrian Arab Republic', 'SYR', '760', 'yes', '963', '.sy'),
(218, 'TW', 'Taiwan', 'Republic of China (Taiwan)', 'TWN', '158', 'former', '886', '.tw'),
(219, 'TJ', 'Tajikistan', 'Republic of Tajikistan', 'TJK', '762', 'yes', '992', '.tj'),
(220, 'TZ', 'Tanzania', 'United Republic of Tanzania', 'TZA', '834', 'yes', '255', '.tz'),
(221, 'TH', 'Thailand', 'Kingdom of Thailand', 'THA', '764', 'yes', '66', '.th'),
(222, 'TL', 'Timor-Leste (East Timor)', 'Democratic Republic of Timor-Leste', 'TLS', '626', 'yes', '670', '.tl'),
(223, 'TG', 'Togo', 'Togolese Republic', 'TGO', '768', 'yes', '228', '.tg'),
(224, 'TK', 'Tokelau', 'Tokelau', 'TKL', '772', 'no', '690', '.tk'),
(225, 'TO', 'Tonga', 'Kingdom of Tonga', 'TON', '776', 'yes', '676', '.to'),
(226, 'TT', 'Trinidad and Tobago', 'Republic of Trinidad and Tobago', 'TTO', '780', 'yes', '1+868', '.tt'),
(227, 'TN', 'Tunisia', 'Republic of Tunisia', 'TUN', '788', 'yes', '216', '.tn'),
(228, 'TR', 'Turkey', 'Republic of Turkey', 'TUR', '792', 'yes', '90', '.tr'),
(229, 'TM', 'Turkmenistan', 'Turkmenistan', 'TKM', '795', 'yes', '993', '.tm'),
(230, 'TC', 'Turks and Caicos Islands', 'Turks and Caicos Islands', 'TCA', '796', 'no', '1+649', '.tc'),
(231, 'TV', 'Tuvalu', 'Tuvalu', 'TUV', '798', 'yes', '688', '.tv'),
(232, 'UG', 'Uganda', 'Republic of Uganda', 'UGA', '800', 'yes', '256', '.ug'),
(233, 'UA', 'Ukraine', 'Ukraine', 'UKR', '804', 'yes', '380', '.ua'),
(234, 'AE', 'United Arab Emirates', 'United Arab Emirates', 'ARE', '784', 'yes', '971', '.ae'),
(235, 'GB', 'United Kingdom', 'United Kingdom of Great Britain and Nothern Ireland', 'GBR', '826', 'yes', '44', '.uk'),
(236, 'US', 'United States', 'United States of America', 'USA', '840', 'yes', '1', '.us'),
(237, 'UM', 'United States Minor Outlying Islands', 'United States Minor Outlying Islands', 'UMI', '581', 'no', 'NONE', 'NONE'),
(238, 'UY', 'Uruguay', 'Eastern Republic of Uruguay', 'URY', '858', 'yes', '598', '.uy'),
(239, 'UZ', 'Uzbekistan', 'Republic of Uzbekistan', 'UZB', '860', 'yes', '998', '.uz'),
(240, 'VU', 'Vanuatu', 'Republic of Vanuatu', 'VUT', '548', 'yes', '678', '.vu'),
(241, 'VA', 'Vatican City', 'State of the Vatican City', 'VAT', '336', 'no', '39', '.va'),
(242, 'VE', 'Venezuela', 'Bolivarian Republic of Venezuela', 'VEN', '862', 'yes', '58', '.ve'),
(243, 'VN', 'Vietnam', 'Socialist Republic of Vietnam', 'VNM', '704', 'yes', '84', '.vn'),
(244, 'VG', 'Virgin Islands, British', 'British Virgin Islands', 'VGB', '092', 'no', '1+284', '.vg'),
(245, 'VI', 'Virgin Islands, US', 'Virgin Islands of the United States', 'VIR', '850', 'no', '1+340', '.vi'),
(246, 'WF', 'Wallis and Futuna', 'Wallis and Futuna', 'WLF', '876', 'no', '681', '.wf'),
(247, 'EH', 'Western Sahara', 'Western Sahara', 'ESH', '732', 'no', '212', '.eh'),
(248, 'YE', 'Yemen', 'Republic of Yemen', 'YEM', '887', 'yes', '967', '.ye'),
(249, 'ZM', 'Zambia', 'Republic of Zambia', 'ZMB', '894', 'yes', '260', '.zm'),
(250, 'ZW', 'Zimbabwe', 'Republic of Zimbabwe', 'ZWE', '716', 'yes', '263', '.zw');


ALTER TABLE `country_t` ADD `spanish_name` VARCHAR( 150 ) NULL;
Update `country_t` SET spanish_name = "Afganist&aacute;n" WHERE iso2 = "AF";
Update `country_t` SET spanish_name = "Islas &Acirc;land" WHERE iso2 = "AX";
Update `country_t` SET spanish_name = "Albania" WHERE iso2 = "AL";
Update `country_t` SET spanish_name = "Argelia" WHERE iso2 = "DZ";
Update `country_t` SET spanish_name = "Samoa Americana" WHERE iso2 = "AS";
Update `country_t` SET spanish_name = "Andorra" WHERE iso2 = "AD";
Update `country_t` SET spanish_name = "Angola" WHERE iso2 = "AO";
Update `country_t` SET spanish_name = "Anguilla" WHERE iso2 = "AI";
Update `country_t` SET spanish_name = "Ant&aacute;rtida" WHERE iso2 = "AQ";
Update `country_t` SET spanish_name = "Antigua y Barbuda" WHERE iso2 = "AG";
Update `country_t` SET spanish_name = "Argentina" WHERE iso2 = "AR";
Update `country_t` SET spanish_name = "Armenia" WHERE iso2 = "AM";
Update `country_t` SET spanish_name = "Aruba" WHERE iso2 = "AW";
Update `country_t` SET spanish_name = "Australia" WHERE iso2 = "AU";
Update `country_t` SET spanish_name = "Austria" WHERE iso2 = "AT";
Update `country_t` SET spanish_name = "Azerbaiy&aacute;n" WHERE iso2 = "AZ";
Update `country_t` SET spanish_name = "Bahamas" WHERE iso2 = "BS";
Update `country_t` SET spanish_name = "Bahrein" WHERE iso2 = "BH";
Update `country_t` SET spanish_name = "Bangladesh" WHERE iso2 = "BD";
Update `country_t` SET spanish_name = "Barbados" WHERE iso2 = "BB";
Update `country_t` SET spanish_name = "Bielorrusia" WHERE iso2 = "BY";
Update `country_t` SET spanish_name = "B&eacute;lgica" WHERE iso2 = "BE";
Update `country_t` SET spanish_name = "Belice" WHERE iso2 = "BZ";
Update `country_t` SET spanish_name = "Ben&iacute;n" WHERE iso2 = "BJ";
Update `country_t` SET spanish_name = "Bermudas" WHERE iso2 = "BM";
Update `country_t` SET spanish_name = "But&aacute;n" WHERE iso2 = "BT";
Update `country_t` SET spanish_name = "Bolivia" WHERE iso2 = "BO";
Update `country_t` SET spanish_name = "Caribe Neerland&eacute;s" WHERE iso2 = "BQ";
Update `country_t` SET spanish_name = "Bosnia-Herzegovina" WHERE iso2 = "BA";
Update `country_t` SET spanish_name = "Botswana" WHERE iso2 = "BW";
Update `country_t` SET spanish_name = "Isla Bouvet" WHERE iso2 = "BV";
Update `country_t` SET spanish_name = "Brasil" WHERE iso2 = "BR";
Update `country_t` SET spanish_name = "Territorio Brit&aacute;nico del Oc&eacute;ano Indico" WHERE iso2 = "IO";
Update `country_t` SET spanish_name = "Brunei Darussalam" WHERE iso2 = "BN";
Update `country_t` SET spanish_name = "Bulgaria" WHERE iso2 = "BG";
Update `country_t` SET spanish_name = "Burkina Faso" WHERE iso2 = "BF";
Update `country_t` SET spanish_name = "Burundi" WHERE iso2 = "BI";
Update `country_t` SET spanish_name = "Camboya" WHERE iso2 = "KH";
Update `country_t` SET spanish_name = "Camer&uacute;n" WHERE iso2 = "CM";
Update `country_t` SET spanish_name = "Canad&aacute;" WHERE iso2 = "CA";
Update `country_t` SET spanish_name = "Cabo Verde" WHERE iso2 = "CV";
Update `country_t` SET spanish_name = "Islas Caim&aacute;n" WHERE iso2 = "KY";
Update `country_t` SET spanish_name = "Rep&uacute;blica Centroafricana" WHERE iso2 = "CF";
Update `country_t` SET spanish_name = "Chad" WHERE iso2 = "TD";
Update `country_t` SET spanish_name = "Chile" WHERE iso2 = "CL";
Update `country_t` SET spanish_name = "China" WHERE iso2 = "CN";
Update `country_t` SET spanish_name = "Isla de Navidad, Isla Christmas" WHERE iso2 = "CX";
Update `country_t` SET spanish_name = "Islas Cocos" WHERE iso2 = "CC";
Update `country_t` SET spanish_name = "Colombia" WHERE iso2 = "CO";
Update `country_t` SET spanish_name = "Comores" WHERE iso2 = "KM";
Update `country_t` SET spanish_name = "Rep&uacute;blica del Congo" WHERE iso2 = "CG";
Update `country_t` SET spanish_name = "Islas Cook" WHERE iso2 = "CK";
Update `country_t` SET spanish_name = "Costa Rica" WHERE iso2 = "CR";
Update `country_t` SET spanish_name = "Costa de Marfil" WHERE iso2 = "CI";
Update `country_t` SET spanish_name = "Croacia" WHERE iso2 = "HR";
Update `country_t` SET spanish_name = "Cuba" WHERE iso2 = "CU";
Update `country_t` SET spanish_name = "Curazao" WHERE iso2 = "CW";
Update `country_t` SET spanish_name = "Chipre" WHERE iso2 = "CY";
Update `country_t` SET spanish_name = "Rep&uacute;blica Checa" WHERE iso2 = "CZ";
Update `country_t` SET spanish_name = "Rep&uacute;blica Democr&aacute;tica del Congo" WHERE iso2 = "CD";
Update `country_t` SET spanish_name = "Dinamarca" WHERE iso2 = "DK";
Update `country_t` SET spanish_name = "Djibouti" WHERE iso2 = "DJ";
Update `country_t` SET spanish_name = "Dominica" WHERE iso2 = "DM";
Update `country_t` SET spanish_name = "Rep&uacute;blica Dominicana" WHERE iso2 = "DO";
Update `country_t` SET spanish_name = "Ecuador" WHERE iso2 = "EC";
Update `country_t` SET spanish_name = "Egiipto" WHERE iso2 = "EG";
Update `country_t` SET spanish_name = "El Salvador" WHERE iso2 = "SV";
Update `country_t` SET spanish_name = "Guinea Ecuatorial" WHERE iso2 = "GQ";
Update `country_t` SET spanish_name = "Eritrea" WHERE iso2 = "ER";
Update `country_t` SET spanish_name = "Estonia" WHERE iso2 = "EE";
Update `country_t` SET spanish_name = "Etiop&iacute;a" WHERE iso2 = "ET";
Update `country_t` SET spanish_name = "Islas Malvinas" WHERE iso2 = "FK";
Update `country_t` SET spanish_name = "Islas Feroe" WHERE iso2 = "FO";
Update `country_t` SET spanish_name = "Fiyi" WHERE iso2 = "FJ";
Update `country_t` SET spanish_name = "Finlandia" WHERE iso2 = "FI";
Update `country_t` SET spanish_name = "Francia" WHERE iso2 = "FR";
Update `country_t` SET spanish_name = "Guayana Francesa" WHERE iso2 = "GF";
Update `country_t` SET spanish_name = "Polinesia Francesa" WHERE iso2 = "PF";
Update `country_t` SET spanish_name = "Tierras Australes Frencesas" WHERE iso2 = "TF";
Update `country_t` SET spanish_name = "Gab&oacute;n" WHERE iso2 = "GA";
Update `country_t` SET spanish_name = "Gambia" WHERE iso2 = "GM";
Update `country_t` SET spanish_name = "Georgia" WHERE iso2 = "GE";
Update `country_t` SET spanish_name = "Alemania" WHERE iso2 = "DE";
Update `country_t` SET spanish_name = "Ghana" WHERE iso2 = "GH";
Update `country_t` SET spanish_name = "Gibraltar" WHERE iso2 = "GI";
Update `country_t` SET spanish_name = "Grecia" WHERE iso2 = "GR";
Update `country_t` SET spanish_name = "Groenlandia" WHERE iso2 = "GL";
Update `country_t` SET spanish_name = "Granada" WHERE iso2 = "GD";
Update `country_t` SET spanish_name = "Guadalupe" WHERE iso2 = "GP";
Update `country_t` SET spanish_name = "Guam" WHERE iso2 = "GU";
Update `country_t` SET spanish_name = "Guatemala" WHERE iso2 = "GT";
Update `country_t` SET spanish_name = "Guernsey" WHERE iso2 = "GG";
Update `country_t` SET spanish_name = "Rep&uacute;blica Guinea" WHERE iso2 = "GN";
Update `country_t` SET spanish_name = "Guinea Bissau" WHERE iso2 = "GW";
Update `country_t` SET spanish_name = "Guyana" WHERE iso2 = "GY";
Update `country_t` SET spanish_name = "Haiti" WHERE iso2 = "HT";
Update `country_t` SET spanish_name = "Islas de Heard y McDonald" WHERE iso2 = "HM";
Update `country_t` SET spanish_name = "Honduras" WHERE iso2 = "HN";
Update `country_t` SET spanish_name = "Hong Kong" WHERE iso2 = "HK";
Update `country_t` SET spanish_name = "Hungr&iacute;a" WHERE iso2 = "HU";
Update `country_t` SET spanish_name = "Islandia" WHERE iso2 = "IS";
Update `country_t` SET spanish_name = "India" WHERE iso2 = "IN";
Update `country_t` SET spanish_name = "Indonesia" WHERE iso2 = "ID";
Update `country_t` SET spanish_name = "Ir&aacute;n" WHERE iso2 = "IR";
Update `country_t` SET spanish_name = "Iraq" WHERE iso2 = "IQ";
Update `country_t` SET spanish_name = "Irlanda" WHERE iso2 = "IE";
Update `country_t` SET spanish_name = "Isla Man" WHERE iso2 = "IM";
Update `country_t` SET spanish_name = "Israel" WHERE iso2 = "IL";
Update `country_t` SET spanish_name = "Italia" WHERE iso2 = "IT";
Update `country_t` SET spanish_name = "Jamaica" WHERE iso2 = "JM";
Update `country_t` SET spanish_name = "Jap&oacute;n" WHERE iso2 = "JP";
Update `country_t` SET spanish_name = "Jersey" WHERE iso2 = "JE";
Update `country_t` SET spanish_name = "Jordania" WHERE iso2 = "JO";
Update `country_t` SET spanish_name = "Kazajst&aacute;n" WHERE iso2 = "KZ";
Update `country_t` SET spanish_name = "Kenia" WHERE iso2 = "KE";
Update `country_t` SET spanish_name = "Kiribati" WHERE iso2 = "KI";
Update `country_t` SET spanish_name = "Kosovo" WHERE iso2 = "XK";
Update `country_t` SET spanish_name = "Kuwait" WHERE iso2 = "KW";
Update `country_t` SET spanish_name = "Kirguist&aacute;n" WHERE iso2 = "KG";
Update `country_t` SET spanish_name = "Laos" WHERE iso2 = "LA";
Update `country_t` SET spanish_name = "Letonia" WHERE iso2 = "LV";
Update `country_t` SET spanish_name = "L&iacute;bano" WHERE iso2 = "LB";
Update `country_t` SET spanish_name = "Lesotho" WHERE iso2 = "LS";
Update `country_t` SET spanish_name = "Liberia" WHERE iso2 = "LR";
Update `country_t` SET spanish_name = "Libia" WHERE iso2 = "LY";
Update `country_t` SET spanish_name = "Liechtenstein" WHERE iso2 = "LI";
Update `country_t` SET spanish_name = "Lituania" WHERE iso2 = "LT";
Update `country_t` SET spanish_name = "Luxemburgo" WHERE iso2 = "LU";
Update `country_t` SET spanish_name = "Macao" WHERE iso2 = "MO";
Update `country_t` SET spanish_name = "Macedonia" WHERE iso2 = "MK";
Update `country_t` SET spanish_name = "Madagascar" WHERE iso2 = "MG";
Update `country_t` SET spanish_name = "Malawi" WHERE iso2 = "MW";
Update `country_t` SET spanish_name = "Malasia" WHERE iso2 = "MY";
Update `country_t` SET spanish_name = "Maldivas" WHERE iso2 = "MV";
Update `country_t` SET spanish_name = "Mal&iacute;" WHERE iso2 = "ML";
Update `country_t` SET spanish_name = "Malta" WHERE iso2 = "MT";
Update `country_t` SET spanish_name = "Islas Marshall" WHERE iso2 = "MH";
Update `country_t` SET spanish_name = "Martinica" WHERE iso2 = "MQ";
Update `country_t` SET spanish_name = "Mauritania" WHERE iso2 = "MR";
Update `country_t` SET spanish_name = "Mauricio" WHERE iso2 = "MU";
Update `country_t` SET spanish_name = "Mayotte" WHERE iso2 = "YT";
Update `country_t` SET spanish_name = "M&eacute;xico" WHERE iso2 = "MX";
Update `country_t` SET spanish_name = "Micronesia" WHERE iso2 = "FM";
Update `country_t` SET spanish_name = "Modavia" WHERE iso2 = "MD";
Update `country_t` SET spanish_name = "M&oacute;naco" WHERE iso2 = "MC";
Update `country_t` SET spanish_name = "Mongolia" WHERE iso2 = "MN";
Update `country_t` SET spanish_name = "Montenegro" WHERE iso2 = "ME";
Update `country_t` SET spanish_name = "Montserrat" WHERE iso2 = "MS";
Update `country_t` SET spanish_name = "Marruecos" WHERE iso2 = "MA";
Update `country_t` SET spanish_name = "Mozambique" WHERE iso2 = "MZ";
Update `country_t` SET spanish_name = "Myanmar (Birmania)" WHERE iso2 = "MM";
Update `country_t` SET spanish_name = "Namibia" WHERE iso2 = "NA";
Update `country_t` SET spanish_name = "Nauru" WHERE iso2 = "NR";
Update `country_t` SET spanish_name = "Nepal" WHERE iso2 = "NP";
Update `country_t` SET spanish_name = "Pa&iacute;ses Bajos, Holanda" WHERE iso2 = "NL";
Update `country_t` SET spanish_name = "Nueva Caledonia" WHERE iso2 = "NC";
Update `country_t` SET spanish_name = "Nueva Zelanda" WHERE iso2 = "NZ";
Update `country_t` SET spanish_name = "Nicaragua" WHERE iso2 = "NI";
Update `country_t` SET spanish_name = "Niger" WHERE iso2 = "NE";
Update `country_t` SET spanish_name = "Nigeria" WHERE iso2 = "NG";
Update `country_t` SET spanish_name = "Niue" WHERE iso2 = "NU";
Update `country_t` SET spanish_name = "Norfolk Island" WHERE iso2 = "NF";
Update `country_t` SET spanish_name = "Corea del Norte" WHERE iso2 = "KP";
Update `country_t` SET spanish_name = "Marianas del Norte" WHERE iso2 = "MP";
Update `country_t` SET spanish_name = "Noruega" WHERE iso2 = "NO";
Update `country_t` SET spanish_name = "Om&aacute;man" WHERE iso2 = "OM";
Update `country_t` SET spanish_name = "Pakist&aacute;n" WHERE iso2 = "PK";
Update `country_t` SET spanish_name = "Palau" WHERE iso2 = "PW";
Update `country_t` SET spanish_name = "Palestina" WHERE iso2 = "PS";
Update `country_t` SET spanish_name = "Panam&aacute;" WHERE iso2 = "PA";
Update `country_t` SET spanish_name = "Pap&uacute;a-Nueva Guinea" WHERE iso2 = "PG";
Update `country_t` SET spanish_name = "Paraguay" WHERE iso2 = "PY";
Update `country_t` SET spanish_name = "Per&uacute;" WHERE iso2 = "PE";
Update `country_t` SET spanish_name = "Filipinas" WHERE iso2 = "PH";
Update `country_t` SET spanish_name = "Isla Pitcairn" WHERE iso2 = "PN";
Update `country_t` SET spanish_name = "Polonia" WHERE iso2 = "PL";
Update `country_t` SET spanish_name = "Portugal" WHERE iso2 = "PT";
Update `country_t` SET spanish_name = "Puerto Rico" WHERE iso2 = "PR";
Update `country_t` SET spanish_name = "Qatar" WHERE iso2 = "QA";
Update `country_t` SET spanish_name = "Reuni&oacute;n" WHERE iso2 = "RE";
Update `country_t` SET spanish_name = "Rumania" WHERE iso2 = "RO";
Update `country_t` SET spanish_name = "Federaci&oacute;n Rusa" WHERE iso2 = "RU";
Update `country_t` SET spanish_name = "Ruanda" WHERE iso2 = "RW";
Update `country_t` SET spanish_name = "San Barolom&eacute;" WHERE iso2 = "BL";
Update `country_t` SET spanish_name = "Santa Elena" WHERE iso2 = "SH";
Update `country_t` SET spanish_name = "San Cristobal y Nevis" WHERE iso2 = "KN";
Update `country_t` SET spanish_name = "Santa Luc&iacute;a" WHERE iso2 = "LC";
Update `country_t` SET spanish_name = "San Mart&iacute;n" WHERE iso2 = "MF";
Update `country_t` SET spanish_name = "San Pedro y Miquel&oacute;n" WHERE iso2 = "PM";
Update `country_t` SET spanish_name = "San Vincente y Granadinas" WHERE iso2 = "VC";
Update `country_t` SET spanish_name = "Samoa" WHERE iso2 = "WS";
Update `country_t` SET spanish_name = "San Marino" WHERE iso2 = "SM";
Update `country_t` SET spanish_name = "San Tom&eacute; y Principe" WHERE iso2 = "ST";
Update `country_t` SET spanish_name = "Arabia Saudita" WHERE iso2 = "SA";
Update `country_t` SET spanish_name = "Senegal" WHERE iso2 = "SN";
Update `country_t` SET spanish_name = "Serbia" WHERE iso2 = "RS";
Update `country_t` SET spanish_name = "Seychelles" WHERE iso2 = "SC";
Update `country_t` SET spanish_name = "Sierra Leona" WHERE iso2 = "SL";
Update `country_t` SET spanish_name = "Singapur" WHERE iso2 = "SG";
Update `country_t` SET spanish_name = "Sint Maarten" WHERE iso2 = "SX";
Update `country_t` SET spanish_name = "Eslovaquia" WHERE iso2 = "SK";
Update `country_t` SET spanish_name = "Eslovenia" WHERE iso2 = "SI";
Update `country_t` SET spanish_name = "Islas Salom&oacute;n" WHERE iso2 = "SB";
Update `country_t` SET spanish_name = "Somalia" WHERE iso2 = "SO";
Update `country_t` SET spanish_name = "Sud&aacute;frica" WHERE iso2 = "ZA";
Update `country_t` SET spanish_name = "Sudo Georgia y los Islas Sandwich del Sur" WHERE iso2 = "GS";
Update `country_t` SET spanish_name = "Corea del Sur" WHERE iso2 = "KR";
Update `country_t` SET spanish_name = "Sud&aacute;n del Sur" WHERE iso2 = "SS";
Update `country_t` SET spanish_name = "Espa&ntilde;a" WHERE iso2 = "ES";
Update `country_t` SET spanish_name = "Sri Lanka" WHERE iso2 = "LK";
Update `country_t` SET spanish_name = "Sud&aacute;n" WHERE iso2 = "SD";
Update `country_t` SET spanish_name = "Surinam" WHERE iso2 = "SR";
Update `country_t` SET spanish_name = "Isla Jan Mayen y Archipi&eacute;lago de Svalbard" WHERE iso2 = "SJ";
Update `country_t` SET spanish_name = "Swazilandia" WHERE iso2 = "SZ";
Update `country_t` SET spanish_name = "Suecia" WHERE iso2 = "SE";
Update `country_t` SET spanish_name = "Suiza" WHERE iso2 = "CH";
Update `country_t` SET spanish_name = "Siria" WHERE iso2 = "SY";
Update `country_t` SET spanish_name = "Taiwan" WHERE iso2 = "TW";
Update `country_t` SET spanish_name = "Tadjikistan" WHERE iso2 = "TJ";
Update `country_t` SET spanish_name = "Tanzania" WHERE iso2 = "TZ";
Update `country_t` SET spanish_name = "Tailandia" WHERE iso2 = "TH";
Update `country_t` SET spanish_name = "Timor Oriental" WHERE iso2 = "TL";
Update `country_t` SET spanish_name = "Togo" WHERE iso2 = "TG";
Update `country_t` SET spanish_name = "Tokelau" WHERE iso2 = "TK";
Update `country_t` SET spanish_name = "Tonga" WHERE iso2 = "TO";
Update `country_t` SET spanish_name = "Trinidad y Tobago" WHERE iso2 = "TT";
Update `country_t` SET spanish_name = "T&uacute;ez" WHERE iso2 = "TN";
Update `country_t` SET spanish_name = "Turqu&iacute;a" WHERE iso2 = "TR";
Update `country_t` SET spanish_name = "Turkmenistan" WHERE iso2 = "TM";
Update `country_t` SET spanish_name = "Islas Turcas y Caicos" WHERE iso2 = "TC";
Update `country_t` SET spanish_name = "Tuvalu" WHERE iso2 = "TV";
Update `country_t` SET spanish_name = "Uganda" WHERE iso2 = "UG";
Update `country_t` SET spanish_name = "Ucrania" WHERE iso2 = "UA";
Update `country_t` SET spanish_name = "Emiratos &Aacute;rebes Unidos" WHERE iso2 = "AE";
Update `country_t` SET spanish_name = "Reino Unido" WHERE iso2 = "GB";
Update `country_t` SET spanish_name = "Estados Unidos" WHERE iso2 = "US";
Update `country_t` SET spanish_name = "Islas ultramarinas menores de Estados Unidos" WHERE iso2 = "UM";
Update `country_t` SET spanish_name = "Uruguay" WHERE iso2 = "UY";
Update `country_t` SET spanish_name = "Uzbekist&aacute;n" WHERE iso2 = "UZ";
Update `country_t` SET spanish_name = "Vanuatu" WHERE iso2 = "VU";
Update `country_t` SET spanish_name = "Ciudad del Vaticano" WHERE iso2 = "VA";
Update `country_t` SET spanish_name = "Venezuela" WHERE iso2 = "VE";
Update `country_t` SET spanish_name = "Vietnam" WHERE iso2 = "VN";
Update `country_t` SET spanish_name = "Islas Virgenes Brit&aacute;nicas" WHERE iso2 = "VG";
Update `country_t` SET spanish_name = "Islas Virgenes Americanas" WHERE iso2 = "VI";
Update `country_t` SET spanish_name = "Wallis y Futuna" WHERE iso2 = "WF";
Update `country_t` SET spanish_name = "S&aacute;hara Occidental" WHERE iso2 = "EH";
Update `country_t` SET spanish_name = "Yemen" WHERE iso2 = "YE";
Update `country_t` SET spanish_name = "Zambia" WHERE iso2 = "ZM";
Update `country_t` SET spanish_name = "Zimbabwe" WHERE iso2 = "ZW";