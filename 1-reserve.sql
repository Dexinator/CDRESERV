CREATE TABLE `reservations` (
  `res_id` int(11) NOT NULL,
  `res_date` datetime,
  `res_name` varchar(255) NOT NULL,
  `res_email` varchar(255) NOT NULL,
  `res_tel` varchar(60) NOT NULL,
  `res_notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `reservations`
  ADD PRIMARY KEY (`res_id`),
  ADD KEY `res_date` (`res_date`),
  ADD KEY `res_name` (`res_name`),
  ADD KEY `res_email` (`res_email`),
  ADD KEY `res_tel` (`res_tel`);

ALTER TABLE `reservations`
  MODIFY `res_id` int(11) NOT NULL AUTO_INCREMENT;


    CREATE TABLE `reservations` (
  `res_id` int(11) NOT NULL,
  `res_suc` text NOT NULL,  
  `res_numper` int(2) NOT NULL,
  `res_catgames` text NOT NULL,
  `res_asistencia` varchar(255) NOT NULL,
  `res_notes` text DEFAULT NULL,
  `res_eventTime` datetime NOT NULL,
  `res_name` text NOT NULL,
  `res_telefono` varchar NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `reservations`
  ADD PRIMARY KEY (`res_id`);

ALTER TABLE `reservations`
  MODIFY `res_id` int(11) NOT NULL AUTO_INCREMENT;