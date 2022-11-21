CREATE TABLE IF NOT EXISTS `compte`(
    `code` int(11) NOT NULL,
    `username` varchar(30),
    `hash` varchar(256),
    `rank` int(11),
    PRIMARY KEY (`code`)
);

CREATE TABLE IF NOT EXISTS `adherent`(
    `code` int(11) NOT NULL,
    `prenom` varchar(30) NOT NULL,
    `nom` varchar(30) NOT NULL,
    `compte` int(11),
    PRIMARY KEY (`code`)
);

CREATE TABLE IF NOT EXISTS `reservation`(
    `code` int(11) NOT NULL,
    `debut` timestamp NOT NULL,
    `fin` timestamp NOT NULL,
    PRIMARY KEY (`code`)
);

CREATE TABLE IF NOT EXISTS `joueursAyantReserve`(
    `reservation` int(11) NOT NULL,
    `joueur` int(11) NOT NULL,
    PRIMARY KEY (`reservation`,`joueur`)
);

CREATE TABLE IF NOT EXISTS `duel`(
    `joueur1` int(11) NOT NULL,
    `joueur2` int(11) NOT NULL,
    `vainqueur` tinyint(1),
    `date` timestamp NOT NULL,
    PRIMARY KEY (`joueur1`,`date`)
);

CREATE TABLE IF NOT EXISTS `horaires`(
    `jour` tinyint(1) NOT NULL,
    `ouverture` time NOT NULL,
    `fermeture` time NOT NULL
);

ALTER TABLE `adherent`
    ADD FOREIGN KEY (`compte`) REFERENCES `compte`(`code`);

ALTER TABLE `joueursAyantReserve`
    ADD FOREIGN KEY (`reservation`) REFERENCES `reservation`(`code`);

ALTER TABLE `joueursAyantReserve`
    ADD FOREIGN KEY (`joueur`) REFERENCES `adherent`(`code`);

ALTER TABLE `duel`
    ADD FOREIGN KEY (`joueur1`) REFERENCES `compte`(`code`);

ALTER TABLE `duel`
    ADD FOREIGN KEY (`joueur2`) REFERENCES `compte`(`code`);
