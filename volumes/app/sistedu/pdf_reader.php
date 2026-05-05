<?php error_reporting(E_ALL);
ini_set('display_errors', '1');

define('DB_NAME', 'xaguas_cnpa');
define('DB_USER', 'xaguas_cnpa');
define('DB_PASSWORD', '15230574');
define('DB_HOST', 'localhost');
$id_campeonato = 36;

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$connection) $success = false;
    
    $connection->set_charset("utf8");

    include 'vendor/autoload.php';
 
$text = "";
// Parse pdf file and build necessary objects.
$parser = new \Smalot\PdfParser\Parser();
$pdf    = $parser->parseFile('open1.pdf');
$clave_st = uniqid();
 
//$pages  = $pdf->getPages();
 
// Loop over each page to extract text.
/*foreach ($pages as $page) {
    echo $page->getText();
}*/
$text .= $pdf->getText();



//echo $text."<br><br><br><br>";


$text = "
Stadio Italiano Swim TeamHY-TEK&#39;s MEET MANAGER 7.0 - 11:34 AM  13-12-2018  Paágina 1
Campeonato Nacional de Clausura Open 2018 - 13-12-2018 a 16-12-2018	
Resultados - Jueves 13 Eliminatorias	
 Evento 1  Hombres 50 CL Metro Estilo de Mariposa 	
   Equipo	Nombre Tiempo de Elim
PUC
 22
Saavedra, Diego
1 26,58q
EE
 26
Varas, Carlos
2 26,79q
MAGAL
 16
Cespedes, Diego
3 26,80q
SI
 21
Molina, Diego
4 26,98q
SF
 16
Garcia Mavarez, Dario
*5 27,07q
EE
 19
Cruz, Emilio
*5 27,07q
CDEP
 15
Toledo, Luis
*7 27,20q
EE
 17
Quiroga, Augusto
*7 27,20q
SI
 20
Pinto, Matias
9 27,32q
SF
 14
Barreto Garcia, Jose
10 27,56q
SEREN
 13
Sepulveda, Vicente
11 27,95q
EE
 18
Lechuga, Claudio
12 28,05q
WFE
 15
Conus, Sergio
13 28,06q
SI
 15
De la Rivera, Ignacio
14 28,65q
EE
 17
Ortego, Ignacio
15 28,73q
SF
 16
Medina Mujica, Luis
16 29,13q
WFE
 15
Orizola, Sebastian
17 29,29
SF
 16
Ortiz Mun ñoz, Vicente
18 29,51
MAGAL
 15
Uribe, Hyan
19 29,59
MAGAL
 14
Jara, Cristobal
20 29,79
ARSU
 16
Pfiffer, Martíán
21 30,12
ARENA
 14
Cubillos, Vicente
22 30,31
SF
 14
Tapia Aguilera, Pedro
23 30,33
CDUC
 14
Palma, Pablo
24 30,40
CDEP
 16
Martinez, Sebastian
25 30,70
ARENA
 14
Biskupovic, Nicolas
26 30,93
ARSU
 12
Pinto, Benjamin
27 30,97
APS
 16
Castellanos Villela, Cristian Daniel
*28 31,10
CDUC
 14
Urrutia, Matias
*28 31,10
ARSU
 13
Gajardo, Juan Pablo
30 31,41
EE
 13
Badala, Matteo
31 31,56
RECRE
 13
Aviles, Alonso
*32 31,81
SI
 14
Galleguillos, Julian
*32 31,81
ARSU
 18
Gallardo, Joaquin
34 32,38
ARSU
 12
Palma, Francisco
35 32,47
WFE
 14
Franco, Guillermo
36 32,56
VITAR
 13	
Pilquiman Rodriguez, Nicolas
37 33,06
CDEP
 15
Cardozo, Nicolas
38 33,13
CDUC
 14
Schwerter, Federico
39 33,36
YMCA
 15
Gonzalez, Felipe
40 33,47
MAGAL
 15
Valenzuela, Joaquin
41 34,45
YMCA
 14
Sierra, Diego
42 34,87
CDUC
 13
Pedemonte, Facundo
43 34,97
YMCA
 13
Brenat, Diego
44 35,03
CDUC
 15
Vargas, Simon
45 35,78
RECRE
 17
Cabezas, Maximiliano
46 35,88
ARENA
 12
Gatica, Cristobal
47 36,15
CHIC
 13
Atenas, Juan
48 36,75
VITAR
 13
Fuenteseca, Leon
49 37,04
CDEP
 13
Lorca, Martin
50 38,65
EE
 14
Jung, Tomas
51 39,60	
 Evento 2  Mujeres 50 CL Metro Estilo de Pecho
   Equipo	Nombre Tiempo de Elim
EE
 14
Bennewitz, Catalina
1 37,44q
WFE
 12
Gomez, Sofia
2 38,87q
SF
 14
Salazar Reina, Anamaria
3 40,72q
CDUC
 12
Orpis, Florencia
4 41,71q
CDEP
 14
Bustos, Renata Paz
5 42,62q
CHIC
 17
Fernandez, Constanza
6 42,68q
RECRE
 17
Zaror, Katherine
7 43,18q
POSEI
 14
Quinteros, Elizabeth
8 43,64q
ARSU
 15
Acevedo, Paloma
9 43,74q
CDEP
 17
Hernandez Mun ñoz, Constanza
10 44,25q
MAGAL
 13
Cabello, Giuliana
11 44,39q
CDEP
 15
Zavala, Aranzazu
12 45,51q
ARSU
 14
Pulgar, Antonia
13 46,22q
YMCA
 13
Isla, Josefa
14 46,30q
RECRE
 15
Ibacache, Sofia
15 48,74q
YMCA
 12
Reyes, Matilda
16 49,12q
POSEI
 13
Hansen, Anke
17 51,41
YMCA
 15
Rios, Noribel
18 56,87
YMCA
 15
Hidalgo, Thamara
19 57,51
 Evento 4  Mujeres 400 CL Metro Estilo Libre
   Equipo	Nombre Tiempo de Elim
SI
 14
Penner, Julianna
1 4:38,81q
SI
 21
Valdivia, Mahina
2 4:51,58q
VITAR
 15
Kremer Leger, Constanza
3 4:52,39q
WFE
 14
Klenner, Evaluna
4 4:55,54q
SI
 14
Ramirez, Pia
5 4:59,65q
AERO
 14
Rojas, Catalina
6 5:15,57q
SF
 13
Jara Gallegos, Sofia
7 5:23,73q
MAGAL
 16
Gamboa, Kamila
8 5:23,79q
ARSU
 16
Seyssel, Pamela
9 5:25,94q
CDUC
 13
Delgado Noches, Isidora Antonia
10 5:27,78q
ACADE
 18
Gonzalez, Mailyn
11 5:30,51q
VITAR
 13
Miranda Castro, Jennifer
12 5:34,81q
SF
 12
Rodriguez Moraga, Samanta
13 5:43,71q
POSEI
 13
Hansen, Andra
14 5:49,36q
MAGAL
 13
Romero, Francisca
15 5:50,47q
CDEP
 13
Abate, Antonia
16 5:51,40q
MAGAL
 13
Cabello, Giuliana
17 5:51,48
MAGAL
 15
Rojas, Martina
18 5:51,56
YMCA
 13
Isla, Josefa
19 5:51,75
ACADE
 18
Mun ñoz, Valentina
20 6:00,64
YMCA
 13
Madriaga, Paz
21 6:22,33
CHIC
 12
Cerda, Pilar
22 6:40,33
CHIC
 14
Karkling, Irina
23 6:41,66
 Evento 5  Hombres 200 CL Metro Estilo de Espalda	
   Equipo	Nombre Tiempo de Elim
ACADE
 20
Araya, Vicnete
1 2:15,95q
SF
 15
Medina Rios, Samuel
2 2:18,36q

Stadio Italiano Swim TeamHY-TEK&#39;s MEET MANAGER 7.0 - 11:34 AM  13-12-2018  Paágina 2
Campeonato Nacional de Clausura Open 2018 - 13-12-2018 a 16-12-2018	
Resultados - Jueves 13 Eliminatorias	
Eliminatorias ...   (Evento 5  Hombres 200 CL Metro Estilo de Espalda) 	
   Equipo	Nombre Tiempo de Elim
SF
 15
Martinez Rojas, Diego
3 2:21,12q
EE
 17
Quiroga, Augusto
4 2:21,19q
SI
 18
Ahumada, Maximiliano
5 2:21,32q
BOYAC
 13
Pantoja, Luis
6 2:21,68q
CHIC
 14
Munoz, Benjamin
7 2:28,45q
WFE
 15
Martinez, Vicente
8 2:28,82q
SEREN
 13
Sepulveda, Vicente
9 2:37,63q
ARENA
 13
Gatica, Leonardo
10 2:39,11q
EE
 35
Peruga, Alberto
11 2:40,53q
ARSU
 12
Palma, Francisco
12 2:49,88q
CDEP
 12
Bustos Garcia, Felipe
13 2:55,98q
CDEP
 14
Baeza, Rafael
14 3:17,76q
CDUC
 15
Dominguez, Enrique
--- DQ	
 Evento 6  Mujeres 100 CL Metro Estilo de Mariposa	
   Equipo	Nombre Tiempo de Elim
SI
 14
Penner, Julianna
1 1:06,54q
SI
 26
Perez, Paola
2 1:08,55q
VITAR
 15
Kremer Leger, Constanza
3 1:09,87q
EE
 18
Salazar, Arantza
4 1:11,45q
OHI
 16
Vega Alarcon, Catalina
5 1:12,10q
CDUC
 25
Chamorro, Alejandra
6 1:12,20q
CDUC
 14
Pacheco, Matilda
7 1:12,33q
WFE
 13
Bratz, Josefa
8 1:14,51q
WFE
 15
Martorel, Micaela
9 1:14,64q
SI
 16
Zamorano, Alicia
10 1:14,73q
CDEP
 13
Mun ñoz Barrios, Emilia
11 1:14,88q
EE
 17
Carren ño, Angela
12 1:15,64q
ACADE
 16
Godoy, Kiara
13 1:18,54q
MAGAL
 13
Valdes, Isis
14 1:18,92q
CDUC
 15
Stein, Valentina
15 1:20,96q
CDEP
 17
Cardona, Valeria
16 1:22,02q
CDUC
 15
Puelma, Antonia
17 1:23,87
APS
 13
Ortiz Herna ández, Barbara Aracely
18 1:24,76
RECRE
 12
Pizarro, Rafaela
19 1:25,88
VITAR
 14
Peters Rodriguez, Karen
20 1:36,75
 Evento 7  Hombres 100 CL Metro Estilo de Pecho
   Equipo	Nombre Tiempo de Elim
EE
 17
Ortego, Ignacio
1 1:10,27q
EE
 19
Quintero, Felipe
2 1:11,96q
VALDI
 16
Hansen, Nicolas
3 1:11,99q
SI
 22
Quiroz, Felipe
4 1:12,96q
ACADE
 20
Almonacid, Vicente
5 1:15,38q
EE
 18
Lechuga, Claudio
6 1:15,60q
PUC
 22
De Aranca, Roberto
7 1:17,51q
EE
 13
Salazar, Andoni
8 1:17,72q
ARSU
 13
Gajardo, Juan Pablo
9 1:17,85q
SF
 16
Medina Mujica, Luis
10 1:18,76q
ARENA
 14
Castillo, Nicolas
11 1:20,13q
CDUC
 14
Dufflocq, Julio
12 1:20,72q
ARENA
 14
Cubillos, Vicente
13 1:21,13q
WFE
 14
Crhistopher, Conus
14 1:21,22q
CDEP
 14
Valderrama, Lucas
15 1:21,72q
EE
 14
Bravo, Max
16 1:21,77q
CDEP
 16
Martinez, Sebastian
17 1:22,22
CDUC
 16
Ca áceres, Joaquin
18 1:23,81
CDEP
 14
Acevedo  Celedon, Matias
19 1:24,68
WFE
 14
Franco, Guillermo
20 1:25,48
ARENA
 12
Gatica, Cristobal
21 1:27,52
CDUC
 14
Schwerter, Federico
22 1:32,17
CDEP
 13
Dustin, Vera
23 1:34,38
RECRE
 12
Salvi, Maximo
24 1:34,92
CDEP
 14
Elgueta, Marco Antonio
25 1:35,05
CHIC
 14
Flores, Santiago
26 1:36,23
CHIC
 13
Atenas, Juan
27 1:37,23
CDEP
 12
Bustos Garcia, Felipe
28 1:37,78
CDEP
 15
Castellanos, Cristobal
29 1:38,47
CHIC
 13
Holmgren, Lukas
30 1:39,71
EE
 14
Jung, Tomas
31 1:40,56
CDEP
 12
Rubio, Javier
32 1:43,64
APS
 13
Melin Del Valle, Reiner Aliro
--- DQ	
 Evento 8  Mujeres 200 CL Metro CI
	   Equipo	Nombre Tiempo de Elim
BOYAC
 15
Melo, Laura
1 2:30,11q
BOYAC
 13
Pavas, Luisa
2 2:33,59q
SI
 14
Reyes, Fernanda
3 2:34,30q
OHI
 19
Pen ñailillo Alfonso, Anita Cristina
4 2:39,11q
EE
 18
Salazar, Arantza
5 2:40,60q
OHI
 16
Vega Alarcon, Catalina
6 2:40,93q
WFE
 14
Klenner, Evaluna
7 2:42,03q
CDUC
 17
Bobadilla, Catalina
8 2:43,45q
VITAR
 13
Alberti Mialani, Giuliana
9 2:45,64q
MAGAL
 14
Andersen, Sophia
10 2:48,04q
EE
 12
Engell, Amelie
11 2:48,43q
APS
 14	
Buzolic Moreno, Tonka Alejandra
12 2:48,44q
CDUC
 25
Chamorro, Alejandra
13 2:52,09q
CHIC
 17
Fernandez, Constanza
14 2:55,79q
WFE
 12
Gomez, Sofia
15 2:57,95q
CDUC
 12
Orpis, Florencia
16 2:58,19q
LAUTA
 13
Mora, Alen
17 2:59,07
CDEP
 14
Bustos, Renata Paz
18 3:01,38
CDEP
 13
Mun ñoz Barrios, Emilia
19 3:05,77
ARSU
 16
Garíán, Barbara
20 3:17,35
CHIC
 14
Karkling, Irina
21 3:49,02
CHIC
 12
Cerda, Pilar
22 3:52,12
 Evento 9  Hombres 200 CL Metro Estilo Libre	
   Equipo	Nombre Tiempo de Elim
BOYAC
 20
Ayala, Gustavo
1 1:59,34q
SF
 13
Cisternas Gomez, Eduardo
2 1:59,73q
SI
 20
Pinto, Matias
3 2:00,87q
EE
 26
Varas, Carlos
4 2:01,18q
SF
 19
Perdomo Almiro án, Jose á
5 2:01,83q
MAGAL
 16
Cespedes, Diego
6 2:02,61q

Stadio Italiano Swim TeamHY-TEK&#39;s MEET MANAGER 7.0 - 11:34 AM  13-12-2018  Paágina 3
Campeonato Nacional de Clausura Open 2018 - 13-12-2018 a 16-12-2018	
Resultados - Jueves 13 Eliminatorias	
Eliminatorias ...   (Evento 9  Hombres 200 CL Metro Estilo Libre) 	
   Equipo	Nombre Tiempo de Elim
SI
 14
Madariaga, Lucas
7 2:02,66q
SF
 14
Marchesini Ayala, Alejandro
8 2:03,02q
SSWIM
 21
Pereira, Daniel
9 2:03,59q
CDUC
 15
Bobadilla, Nicolas
10 2:04,61q
CDEP
 15
Toledo, Luis
11 2:05,69q
SI
 14
Montagna, Vicente
12 2:06,15q
MAGAL
 14
Maureira, Javier
13 2:06,71q
SI
 14
Marin, Santiago
14 2:08,08q
ARENA
 13
Henriquez, Martin
15 2:10,18q
SSWIM
 14
Rojas, Joaquin
16 2:10,93q
CHIC
 15
Bobadilla, Patricio
17 2:12,15
VITAR
 15
Pilquiman Rodriguez, Matias
18 2:12,28
WFE
 15
Lerzundi, Sebastian
19 2:12,47
SF
 14
Barreto Garcia, Jose
20 2:14,32
SI
 14
Rau, Constantino
21 2:14,62
MAGAL
 15
Alvarado, Matias
22 2:15,34
MAGAL
 14
Jara, Cristobal
23 2:15,61
EE
 16
Fernandez, Vicente
24 2:15,73
CDUC
 15
Dominguez, Enrique
25 2:16,07
CDEP
 13
Moreno Paffetti, Martin
26 2:17,09
APS
 15
Gonzalez Moreno, Diego Rodrigo
27 2:17,67
ARENA
 12
Gutierrez, Joaquin
28 2:18,22
SF
 14
Tapia Aguilera, Pedro
29 2:18,69
ARENA
 14
Biskupovic, Nicolas
30 2:18,85
MAGAL
 15
Uribe, Hyan
31 2:21,19
SF
 16
Ortiz Mun ñoz, Vicente
32 2:21,49
ARSU
 16
Pfiffer, Martíán
33 2:21,51
MAGAL
 14
Green, Vicente
34 2:23,03
ARSU
 12
Mun ñoz, Elias
35 2:23,68
SF
 13
Alonso Vasquez, Pablo
36 2:24,21
SF
 15
Contreras Donoso, Marco
37 2:24,28
EE
 14
Wensioe, Martin
38 2:25,20
CDEP
 15
Cardozo, Nicolas
39 2:25,76
SF
 14
Braithwaite Danus, Sebastian
40 2:30,09
EE
 14
Bravo, Max
41 2:31,22
MAGAL
 15
Valenzuela, Joaquin
42 2:32,30
EE
 13
Badala, Matteo
43 2:32,35
VITAR
 13	
Pilquiman Rodriguez, Nicolas
44 2:32,41
VITAR
 12
Ramos, Francisco
45 2:34,23
CDUC
 13
Pedemonte, Facundo
46 2:34,62
VITAR
 13
Venegas Perez, Martin
47 2:34,76
VITAR
 13
Fuenteseca, Leon
48 2:40,71
EE
 12
Luscher, Felipe
49 2:46,17
CDEP
 15
Castellanos, Cristobal
50 2:46,58
 Evento 10  Mixto 400 CL Metro Estilo Libre Relevo
 	
Relevo	Equipo Tiempo de Elim
Eliminatorias A
EE
1 3:50,01q
1) Cruz, Emilio M19 2) Varas, Carlos M26
3) Szklaruk-Traipe, Sarah W15 4) Salazar, Arantza W18
A
CDEP
2 4:00,00q
1) Toledo, Luis M15 2) Valderrama, Lucas M14
3) Cardona, Valeria W17	
4) Hernandez Mun ñoz, Constanza W17	
A
SI
3 4:00,01q
1) Rau, Constantino M14 2) Marin, Santiago M14
3) Zamorano, Alicia W16 4) Ramirez, Pia W14
A
CDUC
4 4:08,00q
1) Dominguez, Enrique M15 2) Pacheco, Matilda W14
3) Chamorro, Alejandra W25 4) Bobadilla, Nicolas M15
A
SF
5 4:25,00q
1) Ortiz Mun ñoz, Vicente M16 2) Tapia Aguilera, Pedro M14
3) Salazar Reina, Anamaria W14 4) Palma Gajardo, Daniela W15
A
CHIC
6 4:25,01q
1) Fernandez, Constanza W17 2) Cerda, Pilar W12
3) Holmgren, Lukas M13 4) Atenas, Juan M13
A
ARSU
7 4:35,00q
1) Pinto, Benjamin M12 2) Acevedo, Paloma W15
3) Mun ñoz, Elias M12 4) Seyssel, Pamela W16	
 Evento 11  Mujeres 800 CL Metro Estilo Libre Relevo
 	
Relevo	Equipo Tiempo de Elim
Eliminatorias A
SI
1 8:59,10q
1) Valdivia, Mahina 21 2) Reyes, Fernanda 14
3) Penner, Julianna 14 4) Perez, Paola 26
A
CDEP
2 9:50,00q
1) Anabalon, Sofia 13 2) Bustos, Renata Paz 14
3) Abate, Antonia 13 4) Munñoz Barrios, Emilia 13
A
SF
3 9:59,00q
1) Bruno Colmenares, Camila 14 2) Rodriguez Moraga, Samanta 12
3) Jara Gallegos, Sofia 13 4) Pizarro Brito, Isidora 13
A
EE
4 10:00,01q
1) Engell, Amelie 12 2) Salazar, Arantza 18
3) Spuhr, Marianne 23 4) Bennewitz, Catalina 14
A
MAGAL
5 10:30,00q
1) Valdes, Isis 13 2) Romero, Francisca 13
3) Cabello, Giuliana 13 4) Gamboa, Kamila 16Club CormupaHY-TEK&#39;s MEET MANAGER 7.0 - 7:06 PM  13/12/2018  Paágina 1
Campeonato Nacional de Clausura Open 2018 - 13/12/2018 a 16/12/2018
Resultados - Jueves 13 Final
 Evento 1  Hombres 50 CL Metro Estilo de Mariposa	

Nombre Equipo Tiempo de Finales
Tiempo de Elim Puntos	
Final - A	
Estadio Espanñol
19	1	Cruz, Emilio	26,23	 	27,07	
Estadio Espan ñol	 26	2	Varas, Carlos	26,41	 	26,79	
Asociacion Magallanes	 16	3	Cespedes, Diego	26,52	 	26,80	
Universidad Catolica	 22	4	Saavedra, Diego	26,54	 	26,58	
Cuidad Deportiva	 15	5	Toledo, Luis	26,82	 	27,20	
Stade Francais	 16	6	Garcia Mavarez, Dario	26,85	 	27,07	
Estadio Espan ñol	 17	7	Quiroga, Augusto	26,92	 	27,20	
Stadio Italiano	 21	8	Molina, Diego	27,12	 	26,98	
Final - B	
Stade Francais	 14	9	Barreto Garcia, Jose	27,45	 	27,56	
Natacion la Serena	 13	10	Sepulveda, Vicente	27,86	 	27,95	
Club Deportivo Weyelfe	 15	11	Conus, Sergio	28,20	 	28,06	
Stadio Italiano	 15	12	De la Rivera, Ignacio	28,88	 	28,65	
Stade Francais	 16	13	Medina Mujica, Luis	28,98	 	29,13	
Club Deportivo Weyelfe	 15	14	Orizola, Sebastian	29,02	 	29,29	
Asociacion Magallanes	 15	15	Uribe, Hyan	29,90	 	29,59	 Evento 2  Mujeres 50 CL Metro Estilo de Pecho	

Nombre Equipo Tiempo de Finales
Tiempo de Elim Puntos	
Final - A	
Estadio Espanñol	 14	1	Bennewitz, Catalina	36,74	 	37,44	
Club Deportivo Weyelfe	 12	2	Gomez, Sofia	39,15	 	38,87	
Stade Francais	 14	3	Salazar Reina, Anamaria	39,79	 	40,72	
Club Deportivo UC	 12	4	Orpis, Florencia	41,46	 	41,71	
Cuidad Deportiva	 14	5	Bustos, Renata Paz	41,75	 	42,62	
Club Chicureo	 17	6	Fernandez, Constanza	42,43	 	42,68	
Club Poseidones San Vicente	 14	7	Quinteros, Elizabeth	43,11	 	43,64	
Club Recrear	 17	8	Zaror, Katherine	43,25	 	43,18	
Final - B	
Asoc. Reg. Santiago Unido	 15	9	Acevedo, Paloma	43,53	 	43,74	
Asociacion Magallanes	 13	10	Cabello, Giuliana	44,66	 	44,39	
Asoc. Reg. Santiago Unido	 14	11	Pulgar, Antonia	45,42	 	46,22	
Cuidad Deportiva	 15	12	Zavala, Aranzazu	45,45	 	45,51	
Club Deportivo YMCA Santiago	 13	13	Isla, Josefa	45,99	 	46,30	
Club Recrear	 15	14	Ibacache, Sofia	48,78	 	48,74	
Club Poseidones San Vicente	 13	15	Hansen, Anke	51,03	 	51,41	
Club Deportivo YMCA Santiago	 12	16	Reyes, Matilda	51,23	 	49,12	
Evento 3  Hombres 800 CL Metro Estilo Libre	
Nombre Equipo Tiempo de Finales
Tiempo para Sembrado Puntos
Seleccion Boyaca- Colombia
 20	1	Ayala, Gustavo	8:30,61	 	8:39,51	
Stadio Italiano	 22	2	Trewhela Pfeifer, Vicente	8:32,60	 	8:50,00	
Stade Francais	 30	3	Segovia Ramos, Johndry	8:40,17	 	8:44,01	
Stade Francais	 13	4	Cisternas Gomez, Eduardo	8:42,80	 	9:11,37	
Stadio Italiano	 14	5	Marin, Santiago	9:02,15	 	9:10,87	
Stadio Italiano	 14	6	Montagna, Vicente	9:06,85	 	9:16,67	
Stadio Italiano	 14	7	Rau, Constantino	9:29,74	 	8:53,98	
Club Santiago Swim	 14	8	Rojas, Joaquin	9:35,77	 	9:16,50	
Asociacion Magallanes	 15	9	Alvarado, Matias	9:37,78	 	9:47,00	
Rama de Natacion Vitacura	 15	10	Pilquiman Rodriguez, Matias	9:55,54	 	8:27,35

Club CormupaHY-TEK&#39;s MEET MANAGER 7.0 - 7:06 PM  13/12/2018  Paágina 2
Campeonato Nacional de Clausura Open 2018 - 13/12/2018 a 16/12/2018
Resultados - Jueves 13 Final
(Evento 3  Hombres 800 CL Metro Estilo Libre)	

Nombre Equipo Tiempo de Finales
Tiempo para Sembrado Puntos
Estadio Espan ñol
 16	11	Fernandez, Vicente	10:11,95	 	9:40,01	
Asociacion Punta Arenas	 13	12	Gomez, David	10:15,47	 	10:08,41	
Asoc. Reg. Santiago Unido	 12	13	Mun ñoz, Elias	10:25,78	 	9:50,00	
Rama de Natacion Vitacura	 12	14	Ramos, Francisco	11:20,53	 	10:23,16	
Rama de Natacion Vitacura	 13	15	Venegas Perez, Martin	11:33,86	 	9:55,12	
Estadio Espan ñol	 12	16	Luscher, Felipe	12:02,15	 	10:50,01	 Evento 4  Mujeres 400 CL Metro Estilo Libre	

Nombre Equipo Tiempo de Finales
Tiempo de Elim Puntos	
Final - A	
Stadio Italiano	 21	1	Valdivia, Mahina	4:35,55	 	4:51,58	
Club Deportivo Weyelfe	 14	2	Klenner, Evaluna	4:47,90	 	4:55,54	
Rama de Natacion Vitacura	 15	3	Kremer Leger, Constanza	4:52,74	 	4:52,39	
Stade Francais	 13	4	Jara Gallegos, Sofia	5:17,45	 	5:23,73	
Asociacion Magallanes	 16	5	Gamboa, Kamila	5:21,11	 	5:23,79	
Asoc. Reg. Santiago Unido	 16	6	Seyssel, Pamela	5:21,19	 	5:25,94	
Club Deportivo UC	 13	7	Delgado Noches, Isidora Antonia	5:21,27	 	5:27,78	
Academia Natacion Vinña del Mar	 18	8	Gonzalez, Mailyn	5:33,06	 	5:30,51	
Final - B	
Cuidad Deportiva	 13	9	Abate, Antonia	5:41,86	 	5:51,40	
Stade Francais	 12	10	Rodriguez Moraga, Samanta	5:43,55	 	5:43,71	
Asociacion Magallanes	 13	11	Romero, Francisca	5:45,44	 	5:50,47	
Club Deportivo YMCA Santiago	 13	12	Isla, Josefa	5:49,19	 	5:51,75	
Asociacion Magallanes	 15	13	Rojas, Martina	5:50,68	 	5:51,56	
Club Poseidones San Vicente	 13	14	Hansen, Andra	5:55,86	 	5:49,36	
Asociacion Magallanes	 13	15	Cabello, Giuliana	5:57,31	 	5:51,48	
Rama de Natacion Vitacura	 13	---	Miranda Castro, Jennifer	DQ	 	5:34,81	 Evento 5  Hombres 200 CL Metro Estilo de Espalda	

Nombre Equipo Tiempo de Finales
Tiempo de Elim Puntos	
Final - A	
Academia Natacion Vinña del Mar	 20	1	Araya, Vicnete	2:12,76	 	2:15,95	
Stadio Italiano	 18	2	Ahumada, Maximiliano	2:13,70	 	2:21,32	
Seleccion Boyaca- Colombia	 13	3	Pantoja, Luis	2:15,41	 	2:21,68	
Stade Francais	 15	4	Martinez Rojas, Diego	2:15,70	 	2:21,12	
Stade Francais	 15	5	Medina Rios, Samuel	2:16,64	 	2:18,36	
Estadio Espan ñol	 17	6	Quiroga, Augusto	2:20,80	 	2:21,19	
Club Chicureo	 14	7	Munoz, Benjamin	2:28,27	 	2:28,45	
Club Deportivo Weyelfe	 15	8	Martinez, Vicente	2:28,33	 	2:28,82	
Final - B	
Natacion la Serena	 13	9	Sepulveda, Vicente	2:36,71	 	2:37,63	
Asociacion Punta Arenas	 13	10	Gatica, Leonardo	2:44,51	 	2:39,11	
Asoc. Reg. Santiago Unido	 12	11	Palma, Francisco	2:46,47	 	2:49,88	
Cuidad Deportiva	 12	12	Bustos Garcia, Felipe	2:51,08	 	2:55,98	
Cuidad Deportiva	 14	13	Baeza, Rafael	3:06,15	 	3:17,76	 Evento 6  Mujeres 100 CL Metro Estilo de Mariposa	

Nombre Equipo Tiempo de Finales
Tiempo de Elim Puntos	
Final - A	
Stadio Italiano	 26	1	Perez, Paola	1:05,76	 	1:08,55	
Stadio Italiano	 14	2	Penner, Julianna	1:06,96	 	1:06,54	
Rama de Natacion Vitacura	 15	3	Kremer Leger, Constanza	1:09,69	 	1:09,87

Club CormupaHY-TEK&#39;s MEET MANAGER 7.0 - 7:06 PM  13/12/2018  Paágina 3
Campeonato Nacional de Clausura Open 2018 - 13/12/2018 a 16/12/2018
Resultados - Jueves 13 Final
Final - A ...   (Evento 6  Mujeres 100 CL Metro Estilo de Mariposa)	

Nombre Equipo Tiempo de Finales
Tiempo de Elim Puntos
Cdsc &#39;higgins
 16	4	Vega Alarcon, Catalina	1:10,28	 	1:12,10	
Estadio Espan ñol	 18	5	Salazar, Arantza	1:10,70	 	1:11,45	
Club Deportivo UC	 25	6	Chamorro, Alejandra	1:10,89	 	1:12,20	
Club Deportivo UC	 14	7	Pacheco, Matilda	1:11,41	 	1:12,33	
Club Deportivo Weyelfe	 13	8	Bratz, Josefa	1:12,27	 	1:14,51	
Final - B	
Stadio Italiano	 16	9	Zamorano, Alicia	1:11,76	 	1:14,73	
Club Deportivo Weyelfe	 15	10	Martorel, Micaela	1:15,20	 	1:14,64	
Cuidad Deportiva	 13	11	Mun ñoz Barrios, Emilia	1:15,21	 	1:14,88	
Academia Natacion Vin ña del Mar	 16	12	Godoy, Kiara	1:18,13	 	1:18,54	
Asociacion Magallanes	 13	13	Valdes, Isis	1:18,14	 	1:18,92	
Club Deportivo UC	 15	14	Stein, Valentina	1:20,54	 	1:20,96	
Club Deportivo UC	 15	15	Puelma, Antonia	1:22,60	 	1:23,87	
Asociacio án Puertas del Sol	 13	16	Ortiz Herna ández, Barbara Aracely	1:23,39	 	1:24,76	 Evento 7  Hombres 100 CL Metro Estilo de Pecho	

Nombre Equipo Tiempo de Finales
Tiempo de Elim Puntos	
Final - A	
Estadio Espanñol	 19	1	Quintero, Felipe	1:09,60	 	1:11,96	
Estadio Espan ñol	 17	2	Ortego, Ignacio	1:10,08	 	1:10,27	
Asociacion Valdivia	 16	3	Hansen, Nicolas	1:11,04	 	1:11,99	
Stadio Italiano	 22	4	Quiroz, Felipe	1:12,57	 	1:12,96	
Estadio Espan ñol	 18	5	Lechuga, Claudio	1:12,84	 	1:15,60	
Universidad Catolica	 22	6	De Aranca, Roberto	1:13,77	 	1:17,51	
Estadio Espan ñol	 13	7	Salazar, Andoni	1:15,27	 	1:17,72	
Academia Natacion Vin ña del Mar	 20	8	Almonacid, Vicente	1:16,11	 	1:15,38	
Final - B	
Stade Francais	 16	9	Medina Mujica, Luis	1:16,82	 	1:18,76	
Asoc. Reg. Santiago Unido	 13	10	Gajardo, Juan Pablo	1:17,10	 	1:17,85	
Asociacion Punta Arenas	 14	11	Cubillos, Vicente	1:18,04	 	1:21,13	
Club Deportivo Weyelfe	 14	12	Crhistopher, Conus	1:18,62	 	1:21,22	
Asociacion Punta Arenas	 14	13	Castillo, Nicolas	1:20,40	 	1:20,13	
Club Deportivo UC	 14	14	Dufflocq, Julio	1:21,90	 	1:20,72	
Cuidad Deportiva	 14	15	Valderrama, Lucas	1:23,24	 	1:21,72	
Estadio Espan ñol	 14	---	Bravo, Max	DQ	 	1:21,77	 Evento 8  Mujeres 200 CL Metro CI	

Nombre Equipo Tiempo de Finales
Tiempo de Elim Puntos	
Final - A	
Seleccion Boyaca- Colombia	 15	1	Melo, Laura	2:26,85	 	2:30,11	
Stadio Italiano	 14	2	Reyes, Fernanda	2:28,36	 	2:34,30	
Seleccion Boyaca- Colombia	 13	3	Pavas, Luisa	2:29,89	 	2:33,59	
Cdsc &#39;higgins	 19	4	Penñailillo Alfonso, Anita Cristina	2:35,41	 	2:39,11	
Cdsc &#39;higgins	 16	5	Vega Alarcon, Catalina	2:39,33	 	2:40,93	
Estadio Espan ñol	 18	6	Salazar, Arantza	2:39,56	 	2:40,60	
Club Deportivo Weyelfe	 14	7	Klenner, Evaluna	2:40,79	 	2:42,03	
Rama de Natacion Vitacura	 13	8	Alberti Mialani, Giuliana	2:43,79	 	2:45,64	
Final - B	
Asociacion Magallanes	 14	9	Andersen, Sophia	2:46,41	 	2:48,04	
Estadio Espan ñol	 12	10	Engell, Amelie	2:49,17	 	2:48,43	
Asociacio án Puertas del Sol	 14	11	Buzolic Moreno, Tonka Alejandra	2:51,39	 	2:48,44	
Club Deportivo Weyelfe	 12	12	Gomez, Sofia	2:54,24	 	2:57,95

Club CormupaHY-TEK&#39;s MEET MANAGER 7.0 - 7:06 PM  13/12/2018  Paágina 4
Campeonato Nacional de Clausura Open 2018 - 13/12/2018 a 16/12/2018
Resultados - Jueves 13 Final
...   (Evento 8  Mujeres 200 CL Metro CI)	

Nombre Equipo Tiempo de Finales
Tiempo de Elim Puntos
Natacion Lautaro
 13	13	Mora, Alen	2:56,52	 	2:59,07	
Club Deportivo UC	 12	14	Orpis, Florencia	2:57,92	 	2:58,19	
Cuidad Deportiva	 14	15	Bustos, Renata Paz	3:00,11	 	3:01,38	
Cuidad Deportiva	 13	16	Mun ñoz Barrios, Emilia	3:04,66	 	3:05,77	 Evento 9  Hombres 200 CL Metro Estilo Libre	

Nombre Equipo Tiempo de Finales
Tiempo de Elim Puntos	
Final - A	
Stade Francais	 19	1	Perdomo Almiroán, Jose á	1:57,44	 	2:01,83	
Stade Francais	 13	2	Cisternas Gomez, Eduardo	1:58,63	 	1:59,73	
Estadio Espan ñol	 26	3	Varas, Carlos	1:58,66	 	2:01,18	
Stadio Italiano	 20	4	Pinto, Matias	1:59,17	 	2:00,87	
Stade Francais	 14	5	Marchesini Ayala, Alejandro	2:01,00	 	2:03,02	
Seleccion Boyaca- Colombia	 20	6	Ayala, Gustavo	2:01,13	 	1:59,34	
Stadio Italiano	 14	7	Madariaga, Lucas	2:01,21	 	2:02,66	
Asociacion Magallanes	 16	8	Cespedes, Diego	2:01,67	 	2:02,61	
Final - B	
Club Deportivo UC	 15	9	Bobadilla, Nicolas	2:03,17	 	2:04,61	
Cuidad Deportiva	 15	10	Toledo, Luis	2:04,12	 	2:05,69	
Asociacion Magallanes	 14	11	Maureira, Javier	2:04,42	 	2:06,71	
Stadio Italiano	 14	12	Montagna, Vicente	2:05,64	 	2:06,15	
Asociacion Punta Arenas	 13	13	Henriquez, Martin	2:06,29	 	2:10,18	
Stadio Italiano	 14	14	Marin, Santiago	2:06,36	 	2:08,08	
Club Chicureo	 15	15	Bobadilla, Patricio	2:11,90	 	2:12,15	
Club Santiago Swim	 14	16	Rojas, Joaquin	2:12,43	 	2:10,93	 Evento 10  Mixto 400 CL Metro Estilo Libre Relevo	
 
Equipo Relevo Tiempo de Finales
Tiempo de Elim Puntos	
Final - A	
    A	1	Estadio Espanñol	3:52,23	 	3:50,01	
1) Cruz, Emilio M19	2) Varas, Carlos M26 3) Szklaruk-Traipe, Sarah W154) Spuhr, Marianne W23
    A	
2	Stadio Italiano	3:57,77	 	4:00,01	
1) Ahumada, Maximiliano M18	2) Valdivia, Mahina W21 3) Pinto, Matias M204) Reyes, Fernanda W14
    A	
3	Stade Francais	4:07,21	 	4:25,00	
1) Pizarro Brito, Isidora W13	2) Garcia Mavarez, Dario M16 3) Salazar Reina, Anamaria W144) Perdomo Almiroán, Jose á M19
    A	
4	Club Deportivo UC	4:10,12	 	4:08,00	
1) Dominguez, Enrique M15	2) Pacheco, Matilda W14 3) Chamorro, Alejandra W254) Bobadilla, Nicolas M15
    A	
5	Cuidad Deportiva	4:10,94	 	4:00,00	
1) Toledo, Luis M15	2) Valderrama, Lucas M14 3) Cardona, Valeria W17	4) Hernandez Munñoz, Constanza W17	
    A	6	Asoc. Reg. Santiago Unido	4:43,08	 	4:35,00	
1) Pinto, Benjamin M12	2) Acevedo, Paloma W15 3) Munñoz, Elias M12 4) Seyssel, Pamela W16
    A	
7	Club Chicureo	5:13,24	 	4:25,01	
1) Fernandez, Constanza W17	2) Cerda, Pilar W12 3) Holmgren, Lukas M134) Atenas, Juan M13	 Evento 11  Mujeres 800 CL Metro Estilo Libre Relevo	
 
Equipo Relevo Tiempo de Finales
Tiempo de Elim Puntos	
Final - A	
    A	1	Stadio Italiano	9:20,63	 	8:59,10	
1) Penner, Julianna 14	2) Valdivia, Mahina 213) Zamorano, Alicia 164) Reyes, Fernanda 14
    A	
2	Estadio Espan ñol	9:56,76	 	10:00,01	
1) Bennewitz, Catalina 14	2) Salazar, Arantza 18 3) Spuhr, Marianne 234) Engell, Amelie 12
    A	
3	Stade Francais	10:21,00	 	9:59,00	
1) Bruno Colmenares, Camila 14	2) Contreras Donoso, Maríáa 15 3) Jara Gallegos, Sofia 134) Pizarro Brito, Isidora 13

Club CormupaHY-TEK&#39;s MEET MANAGER 7.0 - 7:06 PM  13/12/2018  Paágina 5
Campeonato Nacional de Clausura Open 2018 - 13/12/2018 a 16/12/2018
Resultados - Jueves 13 Final
Final - A ...   (Evento 11  Mujeres 800 CL Metro Estilo Libre Relevo)	
 
Equipo Relevo Tiempo de Finales
Tiempo de Elim Puntos
    A	
4	Asociacion Magallanes	10:39,06	 	10:30,00	
1) Valdes, Isis 13	2) Romero, Francisca 13 3) Cabello, Giuliana 134) Gamboa, Kamila 16
    A	
5	Cuidad Deportiva	11:01,38	 	9:50,00	
1) Anabalon, Sofia 13	2) Bustos, Renata Paz 14 3) Abate, Antonia 134) Tafra, Simone 14Club CormupaHY-TEK&#39;s MEET MANAGER 7.0 - 1:57 PM  14/12/2018  Paágina 1
Campeonato Nacional de Clausura Open 2018 - 13/12/2018 a 16/12/2018	
Resultados - Viernes 14 Eliminatorias	
 #12  Mujeres 50 Metro Mariposa
  Nombre         Equipo	Tiempo de Elim	
SI
 26
Perez, Paola
1 31,20
MAYOR
 14
Hafon, Gabriela
2 32,15
EE
 18
Salazar, Arantza
3 32,38
EE
 17
Carren ño, Angela
4 32,56
SI
 16
Zamorano, Alicia
5 32,67
CDUC
 25
Chamorro, Alejandra
6 32,68
WFE
 13
Bratz, Josefa
7 32,83
WFE
 15
Martorel, Micaela
8 32,91
CDEP
 17
Cardona, Valeria
9 33,11
CDUC
 15
Stein, Valentina
10 33,45
EE
 15
Quiroga, Renata
11 33,68
MAGAL
 16
Gamboa, Kamila
12 33,86
MAGAL
 14
Andersen, Sophia
13 33,96
APS
 14	
Buzolic Moreno, Tonka Alejandra
14 34,30
APS
 13	
Ortiz Herna ández, Barbara Aracely
15 34,78
POSEI
 14
Quinteros, Elizabeth
16 35,39
LAUTA
 13
Mora, Alen
17 35,57
ARSU
 16
Seyssel, Pamela
18 35,73
MAYOR
 16
Valenzuela, Daniela
19 35,74
CDUC
 15
Orpis, Maria Belen
20 36,03
CDUC
 12
Orpis, Florencia
21 36,21
RECRE
 12
Pizarro, Rafaela
22 36,70
CDUC
 15
Puelma, Antonia
23 36,92
CDEP
 15
Zavala, Aranzazu
24 37,26
AERO
 17
Ulloa, Bele án
25 37,39
CDUC
 13	
Delgado Noches, Isidora Antonia
26 38,80
ARSU
 15
Acevedo, Paloma
27 39,19
VITAR
 14
Peters Rodriguez, Karen
28 39,43
EE
 32
Isaac, Gloria
29 39,68
YMCA
 12
Reyes, Matilda
30 40,82
ARSU
 16
Garíán, Barbara
31 40,96
CDEP
 14
Tafra, Simone
32 41,39
YMCA
 15
Rios, Noribel
33 42,28
YMCA
 15
Hidalgo, Thamara
34 45,34
YMCA
 12
Ortega, Muriel
35 50,09
 #13  Hombres 50 Metro Pecho
  Nombre         Equipo	Tiempo de Elim	
EE
 19
Quintero, Felipe
1 31,27
EE
 17
Ortego, Ignacio
2 32,00
EE
 26
Varas, Carlos
3 32,18
EE
 18
Lechuga, Claudio
4 32,36
VALDI
 16
Hansen, Nicolas
5 32,67
ARENA
 14
Cubillos, Vicente
6 33,37
SF
 16
Medina Mujica, Luis
7 33,45
MAGAL
 14
Maureira, Javier
8 33,91
ARSU
 18
Gallardo, Joaquin
9 34,08
EE
 13
Salazar, Andoni
10 34,55
ACADE
 20
Almonacid, Vicente
11 34,83
CDEP
 16
Martinez, Sebastian
12 35,87
WFE
 14
Crhistopher, Conus
13 35,88ARSU
 13
Gajardo, Juan Pablo
14 35,90
EE
 14
Bravo, Max
15 36,36
CDEP
 14
Valderrama, Lucas
16 36,63
CDUC
 14
Dufflocq, Julio
17 36,64
CDEP
 14	
Acevedo  Celedon, Matias
18 37,72
WFE
 14
Franco, Guillermo
19 37,82
MAYOR
 17
Gonzalez, Rafael
20 38,20
WFE
 15
Orizola, Sebastian
21 38,65
CDUC
 14
Palma, Pablo
22 39,12
APS
 13	
Melin Del Valle, Reiner Aliro
23 39,20
ARENA
 12
Gatica, Cristobal
24 39,65
CDUC
 15
Maturana, Alberto
25 41,56
MAYOR
 16
Bruce, Vicente
26 42,26
RECRE
 12
Salvi, Maximo
27 42,32
CDEP
 14
Elgueta, Marco Antonio
28 42,36
SF
 14
Nun ñez Tobar, Nahuel
29 42,53
CDEP
 15
Castellanos, Cristobal
30 43,17
MAYOR
 16
Cabrera, Carlos
31 43,79
CHIC
 13
Holmgren, Lukas
32 43,80
CHIC
 14
Flores, Santiago
33 43,83
CDEP
 15
Medina, Sergio
34 44,17
EE
 14
Jung, Tomas
35 44,64
CHIC
 13
Atenas, Juan
36 45,19
CDEP
 13
Lorca, Martin
37 46,86
 #15  Hombres 200 Metro Mariposa
  Nombre         Equipo	Tiempo de Elim	
MAGAL
 16
Cespedes, Diego
1 2:12,63
CDUC
 15
Bobadilla, Nicolas
2 2:16,66
SF
 14
Barreto Garcia, Jose
3 2:23,32
SEREN
 13
Sepulveda, Vicente
4 2:26,58
MAGAL
 14
Green, Vicente
5 2:32,07
WFE
 15
Conus, Sergio
6 2:33,29
SI
 15
De la Rivera, Ignacio
7 2:36,20
ARSU
 16
Pfiffer, Martíán
8 2:39,99
SF
 13
Alonso Vasquez, Pablo
9 2:40,23
ARSU
 12
Pinto, Benjamin
10 2:42,55
ARENA
 13
Gomez, David
11 2:47,26
MAGAL
 14
Jara, Cristobal
12 2:51,75
CDEP
 12
Bruce Robres, Pablo
13 2:54,70
CDEP
 16
Martinez, Sebastian
14 2:58,03
CDEP
 12
Senf, Roberto
15 2:58,55
YMCA
 15
Gonzalez, Felipe
16 3:48,12
VITAR
 13	
Pilquiman Rodriguez, Nicolas	--- DQ
VITAR
 15	
Pilquiman Rodriguez, Matias	--- DQ
 #16  Mujeres 200 Metro Espalda
  Nombre         Equipo	Tiempo de Elim	
EE
 15
Szklaruk-Traipe, Sarah
1 2:22,85
BOYAC
 15
Melo, Laura
2 2:26,05
BOYAC
 13
Pavas, Luisa
3 2:30,79
CDUC
 14
Pacheco, Matilda
4 2:35,07
SF
 13
Pizarro Brito, Isidora
5 2:37,96
CDUC
 17
Bobadilla, Catalina
6 2:38,38SI
 14
Reyes, Fernanda
7 2:39,72
SI
 18
Diaz, Manuela
8 2:40,66
WFE
 14
Llaupe, Janka
9 2:41,73
WFE
 15
Martorel, Micaela
10 2:46,31
VITAR
 13
Miranda Castro, Jennifer
11 2:48,81
EE
 12
Engell, Amelie
12 2:49,06
SF
 14	
Bruno Colmenares, Camila
13 2:55,55
SF
 15
Palma Gajardo, Daniela
14 3:04,85
CDEP
 16
Mun ñoz, Matilde
15 3:05,29
AERO
 13
Ulloa, Monserrat
16 3:14,11
ARSU
 12
Reyes, Gabriela
17 3:20,09
 #17  Hombres 400 Metro Libre
  Nombre         Equipo	Tiempo de Elim
BOYAC
 20
Ayala, Gustavo
1 4:18,56
SF
 13	
Cisternas Gomez, Eduardo
2 4:19,74
SF
 14
Marchesini Ayala, Alejandro
3 4:19,78
BOYAC
 13
Pantoja, Luis
4 4:20,52
SF
 30
Segovia Ramos, Johndry
5 4:22,50
SI
 22
Trewhela Pfeifer, Vicente
6 4:22,58
SF
 15
Martinez Rojas, Diego
7 4:24,75
SI
 14
Marin, Santiago
8 4:25,02
SSWIM
 21
Pereira, Daniel
9 4:26,34
SI
 14
Montagna, Vicente
10 4:26,47
ARSU
 17
Sotelo, Antonio
11 4:36,20
ARENA
 13
Henriquez, Martin
*12 4:39,12
SSWIM
 14
Rojas, Joaquin
*12 4:39,12
MAGAL
 15
Alvarado, Matias
14 4:39,34
CHIC
 15
Bobadilla, Patricio
15 4:40,14
CDUC
 15
Dominguez, Enrique
16 4:42,30
WFE
 15
Martinez, Vicente
17 4:42,93
ARENA
 14
Castillo, Nicolas
18 4:48,13
EE
 16
Fernandez, Vicente
19 4:49,68
APS
 15
Gonzalez Moreno, Diego Rodrigo
20 4:52,53
CDEP
 12
Senf, Roberto
21 4:59,01
SF
 13
Alonso Vasquez, Pablo
22 5:04,03
ARSU
 12
Mun ñoz, Elias
23 5:07,07
EE
 14
Wensioe, Martin
24 5:07,67
SF
 15	
Contreras Donoso, Marco
25 5:08,93
MAGAL
 15
Uribe, Hyan
26 5:15,87
SF
 14	
Braithwaite Danus, Sebastian
27 5:16,95
YMCA
 15
Lobos, David
28 5:18,76
CDUC
 13
Pedemonte, Facundo
29 5:20,63
VITAR
 12
Ramos, Francisco
30 5:22,04
CDUC
 14
Dufflocq, Julio
31 5:22,33
EE
 14
Bravo, Max
32 5:22,67
CDEP
 15
Cardozo, Nicolas
33 5:26,11
VITAR
 13
Venegas Perez, Martin
34 5:28,80
MAGAL
 15
Valenzuela, Joaquin
35 5:30,28
CDEP
 15
Castellanos, Cristobal
36 5:45,13
CDEP
 14
Elgueta, Marco Antonio
37 5:46,82
EE
 12
Luscher, Felipe
38 5:52,62
CDEP
 14
Baeza, Rafael
39 5:59,16
CHIC
 13
Atenas, Juan
40 6:06,98

Club CormupaHY-TEK&#39;s MEET MANAGER 7.0 - 1:57 PM  14/12/2018  Paágina 2
Campeonato Nacional de Clausura Open 2018 - 13/12/2018 a 16/12/2018	
Resultados - Viernes 14 Eliminatorias	
 #18  Mujeres 100 Metro Libre
   Nombre         Equipo	Tiempo de Elim
EE
 15
Szklaruk-Traipe, Sarah
1 59,24
ACADE
 18
Contreras, Gabriela
2 1:02,40
BOYAC
 13
Pavas, Luisa
3 1:02,53
SI
 14
Ramirez, Pia
4 1:04,00
SI
 16
Zamorano, Alicia
5 1:04,53
CDEP
 17
Cardona, Valeria
6 1:04,97
AERO
 14
Rojas, Catalina
7 1:05,61
CDUC
 17
Bobadilla, Catalina
8 1:05,95
OHI
 16
Vega Alarcon, Catalina
9 1:06,82
CDEP
 17	
Hernandez Mun ñoz, Constanza
10 1:06,99
CDEP
 15
Llunell Vilte, Janett
11 1:07,11
EE
 17
Carren ño, Angela
12 1:07,81
EE
 14
Bennewitz, Catalina
13 1:07,98
MAYOR
 13
Cancino, Paz
14 1:08,13
ACADE
 18
Gonzalez, Mailyn
15 1:08,92
WFE
 13
Bratz, Josefa
16 1:08,98
CDUC
 15
Stein, Valentina
17 1:09,29
APS
 13	
Ortiz Herna ández, Barbara Aracely
18 1:09,79
POSEI
 14
Quinteros, Elizabeth
19 1:10,08
CDUC
 13	
Delgado Noches, Isidora Antonia
20 1:10,16
AERO
 17
Ulloa, Bele án
21 1:10,18
ACADE
 16
Godoy, Kiara
22 1:10,90
MAYOR
 16
Valenzuela, Daniela
23 1:11,07
CDUC
 14
Pacheco, Renata
24 1:11,09
ARSU
 16
Seyssel, Pamela
25 1:11,24
LAUTA
 13
Mora, Alen
26 1:11,54
MAGAL
 16
Gamboa, Kamila
27 1:11,72
ARSU
 14
Pulgar, Antonia
28 1:11,75
OHI
 13	
Perromat Villacura, Martina
29 1:11,83
EE
 15
Quiroga, Renata
30 1:11,96
CDUC
 15
Orpis, Maria Belen
31 1:12,02
SF
 15
Contreras Donoso, Maríáa
32 1:13,61
CDUC
 15
Puelma, Antonia
33 1:14,05
POSEI
 13
Hansen, Andra
34 1:14,60
CDEP
 13
Abate, Antonia
35 1:14,61
VITAR
 14
Peters Rodriguez, Karen
36 1:14,67
MAGAL
 15
Rojas, Martina
37 1:15,06
CDEP
 14
Tafra, Simone
38 1:15,27
RECRE
 12
Pizarro, Rafaela
39 1:16,27
CDEP
 15
Zavala, Aranzazu
40 1:16,81
EE
 32
Isaac, Gloria
41 1:18,13
ACADE
 18
Mun ñoz, Valentina
42 1:18,36
RECRE
 17
Zaror, Katherine
43 1:18,60
POSEI
 13
Hansen, Anke
44 1:19,02
ARSU
 12
Reyes, Gabriela
45 1:19,03
CHIC
 12
Cerda, Pilar
46 1:24,93
CHIC
 14
Karkling, Irina
47 1:25,56
RECRE
 15
Ibacache, Sofia
48 1:26,13
 #19  Hombres 100 Metro Espalda
  Nombre         Equipo	Tiempo de Elim
SI
 18
Ahumada, Maximiliano
1 59,73ACADE
 20
Araya, Vicente
2 1:01,07
SF
 19
Perdomo Almiro án, Jose á
3 1:01,54
SF
 15
Medina Rios, Samuel
4 1:03,44
EE
 17
Quiroga, Augusto
5 1:03,66
CHIC
 14
Munoz, Benjamin
6 1:06,63
EE
 35
Peruga, Alberto
7 1:07,76
WFE
 15
Lerzundi, Sebastian
8 1:08,52
CDUC
 16
Ca áceres, Joaquin
9 1:11,53
APS
 15	
Gonzalez Moreno, Diego Rodrigo
10 1:12,22
ARENA
 13
Gatica, Leonardo
11 1:13,40
ARENA
 12
Gutierrez, Joaquin
12 1:14,27
CDUC
 16
Luttges, Arturo
13 1:15,26
SEREN
 13
Sepulveda, Vicente
14 1:15,54
CDEP
 12
Bruce Robres, Pablo
15 1:16,21
ARENA
 13
Gomez, David
16 1:16,51
ARSU
 12
Palma, Francisco
17 1:17,24
CDEP
 12
Bustos Garcia, Felipe
18 1:18,76
VITAR
 13
Venegas Perez, Martin
19 1:21,98
CHIC
 14
Flores, Santiago
20 1:23,02
CDEP
 12
Rubio, Javier
21 1:25,24
CDUC
 15
Vargas, Simon
22 1:25,42
CDEP
 15
Medina, Sergio
23 1:27,18
CDEP
 14
Baeza, Rafael
24 1:28,20
CDEP
 13
Dustin, Vera
25 1:32,08
CHIC
 13
Holmgren, Lukas
26 1:46,89
VITAR
 13
Fuenteseca, Leon
--- DQ
 #21  Mixto 400 Metro Combinado Relevo
 
  Equipo Relevo	
Tiempo de Elim	
A
EE
1 4:10,01	
Szklaruk-Traipe, Sarah W15	Ortego, Ignacio M17
Cruz, Emilio M19 Salazar, Arantza W18
A
BOYAC
2 4:18,00
Pavas, Luisa W13 Melo, Laura W15
Pantoja, Luis M13 Ayala, Gustavo M20
A
SF
3 4:41,32	
Palma Gajardo, Daniela W15	Medina Mujica, Luis M16
Barreto Garcia, Jose M14
Contreras Donoso, Maríáa W15
A
CDUC
4 4:42,00
Dominguez, Enrique M15 Chamorro, Alejandra W25
Bobadilla, Nicolas M15 Bobadilla, Catalina W17
A
ARSU
5 4:53,00
Pulgar, Antonia W14 Gajardo, Juan Pablo M13
Pinto, Benjamin M12 Seyssel, Pamela W16
A
CDEP
6 4:53,53
Anabalon, Sofia W13 Senf, Roberto M12
Toledo, Luis M15 Llunell Vilte, Janett W15
A
SI
7 4:55,01	
Ahumada, Maximiliano M18	Quiroz, Felipe M22
Perez, Paola W26 Reyes, Fernanda W14
A
CHIC
8 4:55,02	
Fernandez, Constanza W17	Karkling, Irina W14
Atenas, Juan M13 Holmgren, Lukas M13	
 #22  Hombres 800 Metro Libre Relevo
  Equipo Relevo	Tiempo de Elim	

A
EE
1 8:30,01
Varas, Carlos 26 Quiroga, Augusto 17
Peruga, Alberto 35 Fernandez, Vicente 16
A
SF
2 8:38,00	
Segovia Ramos, Johndry 30	Medina Rios, Samuel 15
Alonso Vasquez, Pablo 13 Garcia Mavarez, Dario 16
A
ARENA
3 8:52,00
Gutierrez, Joaquin 12 Henriquez, Martin 13
Castillo, Nicolas 14 Biskupovic, Nicolas 14
A
MAGAL
4 9:12,00
Alvarado, Matias 15 Uribe, Hyan 15
Jara, Cristobal 14 Green, Vicente 14
A
CDEP
5 9:27,34	
Acevedo  Celedon, Matias 14	Bruce Robres, Pablo 12
Valderrama, Lucas 14 Cardozo, Nicolas 15
A
ARSU
6 9:28,01
Sotelo, Antonio 17 Munñoz, Elias 12
Pfiffer, Martíán 16 Cevo, Enzo 14
A
CHIC
7 9:29,01
Flores, Santiago 14 Buono-Core, Diego 18
Munoz, Benjamin 14 Bobadilla, Patricio 15
A
SI
8 9:30,00
Pinto, Matias 20 Madariaga, Lucas 14	
Trewhela Pfeifer, Vicente 22	Ahumada, Maximiliano 18Club CormupaHY-TEK&#39;s MEET MANAGER 7.0 - 8:28 AM  15/12/2018  Paágina 1
Campeonato Nacional de Clausura Open 2018 - 13/12/2018 a 16/12/2018	
Resultados - Viernes 14 Final	
 #12  Mujeres 50 Metro Mariposa 
  Nombre         Equipo	
Tiempo de Finales	
SI
 26
Perez, Paola
1 30,42
SI
 16
Zamorano, Alicia
2 31,02
EE
 18
Salazar, Arantza
3 31,35
WFE
 13
Bratz, Josefa
4 31,81
CDUC
 25
Chamorro, Alejandra
5 32,11
MAYOR
 14
Hafon, Gabriela
6 32,22
EE
 17
Carren ño, Angela
7 32,30
WFE
 15
Martorel, Micaela
8 32,65
CDUC
 15
Stein, Valentina
9 32,98
APS
 13	
Ortiz Herna ández, Barbara Aracely
10 33,68
EE
 15
Quiroga, Renata
11 33,72
MAGAL
 16
Gamboa, Kamila
12 33,82
MAGAL
 14
Andersen, Sophia
13 33,93
POSEI
 14
Quinteros, Elizabeth
14 35,67
ARSU
 16
Seyssel, Pamela
15 36,01
LAUTA
 13
Mora, Alen
16 36,25
 #13  Hombres 50 Metro Pecho

  Nombre         Equipo	
Tiempo de Finales	
EE
 19
Quintero, Felipe
1 31,06
EE
 17
Ortego, Ignacio
2 31,50
EE
 26
Varas, Carlos
3 31,75
VALDI
 16
Hansen, Nicolas
4 31,88
EE
 18
Lechuga, Claudio
5 32,07
ARENA
 14
Cubillos, Vicente
6 32,79
SF
 16
Medina Mujica, Luis
7 32,85
MAGAL
 14
Maureira, Javier
8 33,73
EE
 13
Salazar, Andoni
9 34,46
WFE
 14
Crhistopher, Conus
10 34,96
CDEP
 14
Valderrama, Lucas
11 36,23
CDUC
 14
Dufflocq, Julio
12 36,39
ARSU
 13
Gajardo, Juan Pablo
13 36,52
EE
 14
Bravo, Max
14 36,75
CDEP
 14	
Acevedo  Celedon, Matias
15 37,60
CDEP
 16
Martinez, Sebastian
--- DQ
 #14  Mujeres 800 Metro Libre

  Nombre         Equipo	
Tiempo de Finales	
SI
 21
Valdivia, Mahina
1 9:28,05
SI
 14
Penner, Julianna
2 9:30,08
WFE
 14
Klenner, Evaluna
3 9:54,23
VITAR
 15
Kremer Leger, Constanza
4 10:03,64
VITAR
 13
Alberti Mialani, Giuliana
5 10:21,92
APS
 14	
Buzolic Moreno, Tonka Alejandra
6 10:24,55
MAYOR
 13
Cancino, Paz
7 10:28,85
CDEP
 13
Anabalon, Sofia
8 10:31,24
SF
 13
Jara Gallegos, Sofia
9 10:57,25
MAGAL
 13
Valdes, Isis
10 10:59,10
SF
 12
Rodriguez Moraga, Samanta
11 12:02,36	
 #15  Hombres 200 Metro Mariposa

  Nombre         Equipo	
Tiempo de Finales	
MAGAL
 16
Cespedes, Diego
1 2:09,70
CDUC
 15
Bobadilla, Nicolas
2 2:13,71
SF
 14
Barreto Garcia, Jose
3 2:21,78
SEREN
 13
Sepulveda, Vicente
4 2:24,84
MAGAL
 14
Green, Vicente
5 2:31,13
WFE
 15
Conus, Sergio
6 2:33,52
SI
 15
De la Rivera, Ignacio
7 2:33,66
ARSU
 16
Pfiffer, Martíán
8 2:44,77
SF
 13
Alonso Vasquez, Pablo
9 2:36,79
ARENA
 13
Gomez, David
10 2:45,40
CDEP
 12
Bruce Robres, Pablo
11 2:47,00
CDEP
 12
Senf, Roberto
12 2:50,93
MAGAL
 14
Jara, Cristobal
13 2:53,92
CDEP
 16
Martinez, Sebastian
14 3:04,09
YMCA
 15
Gonzalez, Felipe
15 3:44,26
 #16  Mujeres 200 Metro Espalda

  Nombre         Equipo	
Tiempo de Finales
EE
 15
Szklaruk-Traipe, Sarah
1 2:21,65
BOYAC
 13
Pavas, Luisa
2 2:27,11
BOYAC
 15
Melo, Laura
3 2:28,45
SF
 13
Pizarro Brito, Isidora
4 2:34,49
CDUC
 14
Pacheco, Matilda
5 2:34,96
CDUC
 17
Bobadilla, Catalina
6 2:35,88
SI
 14
Reyes, Fernanda
7 2:38,63
SI
 18
Diaz, Manuela
8 2:39,61
WFE
 14
Llaupe, Janka
9 2:39,49
WFE
 15
Martorel, Micaela
10 2:42,59
VITAR
 13
Miranda Castro, Jennifer
11 2:47,35
EE
 12
Engell, Amelie
12 2:52,46
SF
 14	
Bruno Colmenares, Camila
13 2:57,11
CDEP
 16
Mun ñoz, Matilde
14 3:02,97
SF
 15
Palma Gajardo, Daniela
15 3:07,40
AERO
 13
Ulloa, Monserrat
16 3:18,02
 #17  Hombres 400 Metro Libre

  Nombre         Equipo	
Tiempo de Finales
BOYAC
 20
Ayala, Gustavo
1 4:06,41
SI
 22
Trewhela Pfeifer, Vicente
2 4:07,81
SF
 13	
Cisternas Gomez, Eduardo
3 4:10,59
SF
 14
Marchesini Ayala, Alejandro
4 4:14,88
SF
 30
Segovia Ramos, Johndry
5 4:15,01
SF
 15
Martinez Rojas, Diego
6 4:17,67
BOYAC
 13
Pantoja, Luis
7 4:19,15
SI
 14
Marin, Santiago
8 4:23,76
SI
 14
Montagna, Vicente
9 4:25,02
ARENA
 13
Henriquez, Martin
10 4:29,50
MAGAL
 15
Alvarado, Matias
11 4:35,04CDUC
 15
Dominguez, Enrique
12 4:35,13
SSWIM
 14
Rojas, Joaquin
13 4:35,82
CHIC
 15
Bobadilla, Patricio
14 4:40,98
ARENA
 14
Castillo, Nicolas
15 4:43,97
WFE
 15
Martinez, Vicente
16 4:46,87	
 #18  Mujeres 100 Metro Libre

  Nombre         Equipo	
Tiempo de Finales	
EE
 15
Szklaruk-Traipe, Sarah
1 58,78
ACADE
 18
Contreras, Gabriela
2 1:01,09
BOYAC
 13
Pavas, Luisa
3 1:01,68
SI
 16
Zamorano, Alicia
4 1:03,34
CDEP
 17
Cardona, Valeria
5 1:03,99
SI
 14
Ramirez, Pia
6 1:04,10
AERO
 14
Rojas, Catalina
7 1:05,65
CDUC
 17
Bobadilla, Catalina
8 1:06,00
OHI
 16
Vega Alarcon, Catalina
9 1:05,71
CDEP
 15
Llunell Vilte, Janett
10 1:07,32
WFE
 13
Bratz, Josefa
11 1:08,39
APS
 13	
Ortiz Herna ández, Barbara Aracely
12 1:09,12
CDUC
 13	
Delgado Noches, Isidora Antonia
13 1:09,57
CDUC
 15
Stein, Valentina
14 1:10,31
 #19  Hombres 100 Metro Espalda
  Nombre         Equipo	
Tiempo de Finales	
SI
 18
Ahumada, Maximiliano
1 58,89
ACADE
 20
Araya, Vicente
2 58,99
SF
 19
Perdomo Almiro án, Jose á
3 59,95
SF
 15
Medina Rios, Samuel
4 1:02,62
WFE
 15
Lerzundi, Sebastian
5 1:07,35
CHIC
 14
Munoz, Benjamin
6 1:08,10
CDUC
 16
Ca áceres, Joaquin
7 1:11,39
EE
 17
Quiroga, Augusto
--- DQ
APS
 15	
Gonzalez Moreno, Diego Rodrigo
9 1:11,30
ARENA
 13
Gatica, Leonardo
10 1:12,87
SEREN
 13
Sepulveda, Vicente
11 1:13,80
CDUC
 16
Luttges, Arturo
12 1:13,82
CDEP
 12
Bruce Robres, Pablo
13 1:14,50
ARENA
 12
Gutierrez, Joaquin
14 1:14,95
ARSU
 12
Palma, Francisco
15 1:15,39
ARENA
 13
Gomez, David
16 1:16,05
 #20  Mujeres 400 Metro CI

  Nombre         Equipo	
Tiempo de Finales	
SI
 26
Perez, Paola
1 5:18,85
SI
 14
Reyes, Fernanda
2 5:22,62
OHI
 19	
Pen ñailillo Alfonso, Anita Cristina
3 5:32,60
WFE
 14
Klenner, Evaluna
4 5:38,52
OHI
 16
Vega Alarcon, Catalina
5 5:43,22
VITAR
 13
Alberti Mialani, Giuliana
6 5:49,53
CDUC
 25
Chamorro, Alejandra
7 5:50,63
MAGAL
 14
Andersen, Sophia
8 5:55,51
CDEP
 13
Anabalon, Sofia
9 6:01,47
WFE
 12
Gomez, Sofia
10 6:09,98

Club CormupaHY-TEK&#39;s MEET MANAGER 7.0 - 8:28 AM  15/12/2018  Paágina 2
Campeonato Nacional de Clausura Open 2018 - 13/12/2018 a 16/12/2018	
Resultados - Viernes 14 Final	
(#20  Mujeres 400 Metro CI) MAGAL
 13
Cabello, Giuliana
11 6:40,90
 #21  Mixto 400 Metro Combinado Relevo
 
  Equipo Relevo	
Tiempo de Finales	
Final - A
A
EE
1 4:19,02	
Szklaruk-Traipe, Sarah W15	Quintero, Felipe M19
Varas, Carlos M26 Salazar, Arantza W18
A
SI
2 4:24,15	
Ahumada, Maximiliano M18	Quiroz, Felipe M22
Perez, Paola W26 Valdivia, Mahina W21
A
BOYAC
3 4:26,45
Pavas, Luisa W13 Melo, Laura W15
Pantoja, Luis M13 Ayala, Gustavo M20
A
SF
4 4:37,43
Medina Rios, Samuel M15
Salazar Reina, Anamaria W14	
Garcia Mavarez, Dario M16 Pizarro Brito, Isidora W13
A
CDUC
5 4:43,61
Dominguez, Enrique M15 Bobadilla, Nicolas M15
Chamorro, Alejandra W25 Bobadilla, Catalina W17
A
CDEP
6 4:47,63
Anabalon, Sofia W13 Senf, Roberto M12
Toledo, Luis M15 Llunell Vilte, Janett W15
A
ARSU
7 5:04,89
Seyssel, Pamela W16 Gajardo, Juan Pablo M13
Pfiffer, Martíán M16 Pulgar, Antonia W14
A
CHIC
8 6:17,55
Fernandez, Constanza W17	Karkling, Irina W14
Atenas, Juan M13 Holmgren, Lukas M13	
 #22  Hombres 800 Metro Libre Relevo
 
  Equipo Relevo	
Tiempo de Finales	
Final - A
A
SF
1 7:58,21
Martinez Rojas, Diego 15	
Cisternas Gomez, Eduardo 13	
Marchesini Ayala, Alejandro 14	Perdomo Almiro án, Jose á 19
A
SI
2 8:06,97
Pinto, Matias 20 Madariaga, Lucas 14	
Trewhela Pfeifer, Vicente 22	Ahumada, Maximiliano 18
A
EE
3 8:51,77
Ortego, Ignacio 17 Fernandez, Vicente 16
Salazar, Andoni 13 Quiroga, Augusto 17
A
ARENA
4 8:55,19
Gutierrez, Joaquin 12 Henriquez, Martin 13
Castillo, Nicolas 14 Biskupovic, Nicolas 14
A
MAGAL
5 9:15,83
Alvarado, Matias 15 Uribe, Hyan 15
Jara, Cristobal 14 Green, Vicente 14
A
CDEP
6 9:25,18	
Acevedo  Celedon, Matias 14	Bruce Robres, Pablo 12
Valderrama, Lucas 14 Moreno Paffetti, Martin 13
A
CHIC
7 9:33,94
Flores, Santiago 14 Buono-Core, Diego 18
Munoz, Benjamin 14 Bobadilla, Patricio 15
A
ARSU
8 9:39,46
Cevo, Enzo 14 Munñoz, Elias 12
Gallardo, Joaquin 18 Palma, Francisco 12Club CormupaHY-TEK&#39;s MEET MANAGER 7.0 - 11:58 AM  15/12/2018  Paágina 1
Campeonato Nacional de Clausura Open 2018 - 13/12/2018 a 16/12/2018	
Resultados - Sabado 15 Eliminatorias	
 #23  Hombres 50 Metro Libre
   Nombre         Equipo	Tiempo de Elim	
EE
 26
Varas, Carlos
1 24,68
ACADE
 20
Araya, Vicente
2 24,93
EE
 19
Cruz, Emilio
3 25,00
SI
 20
Pinto, Matias
4 25,14
SF
 19
Perdomo Almiro án, Jose á
5 25,17
SI
 21
Molina, Diego
6 25,41
EE
 19
Quintero, Felipe
7 25,47
PUC
 22
Saavedra, Diego
8 25,51
EE
 35
Peruga, Alberto
9 25,57
CDEP
 15
Toledo, Luis
10 25,59
SF
 16
Garcia Mavarez, Dario
11 25,68
EE
 17
Quiroga, Augusto
12 25,74
CDUC
 15
Bobadilla, Nicolas
13 25,86
EE
 18
Lechuga, Claudio
14 26,09
SSWIM
 21
Pereira, Daniel
15 26,11
SI
 14
Madariaga, Lucas
16 26,13
EE
 17
Ortego, Ignacio
17 26,16
MAGAL
 14
Maureira, Javier
18 26,38
WFE
 15
Conus, Sergio
19 26,89
WFE
 15
Lerzundi, Sebastian
20 26,93
OHI
 15
Reyes Orellana, Martin
21 27,04
SF
 16
Ortiz Mun ñoz, Vicente
22 27,21
RECRE
 17
Cabezas, Maximiliano
23 27,33
SF
 14
Tapia Aguilera, Pedro
24 27,37
CDEP
 14
Valderrama, Lucas
25 27,77
RECRE
 13
Aviles, Alonso
26 27,79
MAYOR
 17
Gonzalez, Rafael
27 27,93
MAGAL
 15
Uribe, Hyan
*28 28,08
ARENA
 14
Biskupovic, Nicolas
*28 28,08
CDUC
 16
Luttges, Arturo
30 28,20
WFE
 15
Orizola, Sebastian
31 28,44
MAGAL
 14
Jara, Cristobal
32 28,46
YMCA
 15
Gonzalez, Felipe
33 28,50
EE
 16
Fernandez, Vicente
34 28,52
ARSU
 18
Gallardo, Joaquin
35 28,69
WFE
 14
Franco, Guillermo
36 28,80
CHIC
 18
Buono-Core, Diego
37 28,97
ARSU
 14
Cevo, Enzo
38 28,98
CDUC
 14
Urrutia, Matias
39 29,00
ARENA
 12
Gutierrez, Joaquin
*40 29,08
APS
 16	
Castellanos Villela, Cristian Daniel
*40 29,08
SI
 14
Galleguillos, Julian
42 29,18
CDEP
 14	
Acevedo  Celedon, Matias
43 29,27
AERO
 18
Ortega, Joaquíán
44 29,34
ARENA
 14
Cubillos, Vicente
45 29,38
CDEP
 13
Moreno Paffetti, Martin
46 29,56
MAYOR
 16
Bruce, Vicente
47 29,63
ARSU
 12
Pinto, Benjamin
48 29,65
MAYOR
 16
Grob, Toma ás
49 29,91
MAGAL
 14
Green, Vicente
50 29,95
ARENA
 12
Gatica, Cristobal
51 29,99
CDEP
 14
Elgueta, Marco Antonio
52 30,02
EE
 13
Badala, Matteo
53 30,03MAGAL
 15
Valenzuela, Joaquin
54 30,39
CDEP
 14
Baeza, Rafael
55 30,42
CDUC
 14
Schwerter, Federico
56 30,44
ARENA
 13
Gatica, Leonardo
57 30,55
YMCA
 15
Lobos, David
58 30,61
ARSU
 12
Palma, Francisco
59 30,71
CDUC
 14
Palma, Pablo
60 30,83
CDUC
 14
Dufflocq, Julio
61 30,95
RECRE
 12
Salvi, Maximo
62 31,21
VITAR
 12
Ramos, Francisco
63 31,45
YMCA
 13
Brenat, Diego
64 31,66
EE
 14
Wensioe, Martin
65 31,75
YMCA
 16
Martines, Tomas
66 31,87
CDUC
 15
Maturana, Alberto
67 31,98
YMCA
 14
Sierra, Diego
68 32,04
CDEP
 13
Lorca, Martin
69 32,15
CDEP
 12
Rubio, Javier
70 32,23
CDUC
 15
Vargas, Simon
71 32,26
CDEP
 13
Dustin, Vera
72 33,13
SF
 14
Nun ñez Tobar, Nahuel
73 33,27
CDEP
 15
Medina, Sergio
74 33,41
EE
 12
Luscher, Felipe
75 33,49
AERO
 16
Sepulveda, Felipe
76 33,55
MAYOR
 16
Cabrera, Carlos
77 33,64
EE
 14
Jung, Tomas
78 35,01	
 #24  Mujeres 50 Metro Espalda
  Nombre         Equipo	Tiempo de Elim	
BOYAC
 15
Melo, Laura
1 31,22
EE
 15
Szklaruk-Traipe, Sarah
2 31,50
EE
 23
Spuhr, Marianne
3 32,90
SF
 13
Pizarro Brito, Isidora
4 33,75
SI
 18
Diaz, Manuela
5 34,16
WFE
 14
Llaupe, Janka
6 34,59
WFE
 15
Martorel, Micaela
7 34,61
CDUC
 14
Pacheco, Matilda
8 34,64
EE
 15
Quiroga, Renata
9 34,85
AERO
 14
Rojas, Catalina
10 34,92
EE
 12
Engell, Amelie
11 35,17
APS
 14	
Buzolic Moreno, Tonka Alejandra
12 36,23
CDUC
 14
Pacheco, Renata
13 36,26
MAYOR
 14
Hafon, Gabriela
14 36,56
SF
 14	
Bruno Colmenares, Camila
15 37,26
ARSU
 16
Seyssel, Pamela
16 37,33
ARSU
 14
Pulgar, Antonia
17 37,68
POSEI
 14
Quinteros, Elizabeth
18 37,71
VITAR
 13
Miranda Castro, Jennifer
19 37,76
CDEP
 13
Mun ñoz Barrios, Emilia
20 37,83
AERO
 17
Ulloa, Bele án
21 38,31
CDUC
 15
Orpis, Maria Belen
22 38,45
MAYOR
 16
Valenzuela, Daniela
23 38,71
CDEP
 16
Mun ñoz, Matilde
24 39,02
POSEI
 13
Hansen, Andra
25 40,05
ACADE
 18
Mun ñoz, Valentina
26 40,07
AERO
 13
Ulloa, Monserrat
27 40,26
CDUC
 15
Puelma, Antonia
28 40,43SF
 15
Palma Gajardo, Daniela
29 40,54
ARSU
 15
Acevedo, Paloma
30 41,38
CDUC
 15
Pen ña, Beatriz
31 41,59
RECRE
 12
Pizarro, Rafaela
32 41,68
SF
 15
Contreras Donoso, Maríáa
33 42,15
POSEI
 13
Hansen, Anke
34 42,32
ARSU
 12
Reyes, Gabriela
35 42,86
EE
 16
Alvarado, Pilar
36 43,70
YMCA
 12
Ortega, Muriel
37 44,92
AERO
 13
Sepu álveda, Fernanda
38 45,18
YMCA
 13
Madriaga, Paz
39 45,35
CDEP
 14
Tafra, Simone
40 45,77
YMCA
 15
Rios, Noribel
41 46,11
YMCA
 15
Hidalgo, Thamara
42 47,49
CDEP
 15
Zavala, Aranzazu
--- DQ
EE
 17
Carren ño, Angela
--- DQ	
 #26  Mujeres 200 Metro Pecho
  Nombre         Equipo	Tiempo de Elim	
SI
 14
Reyes, Fernanda
1 2:56,57
OHI
 19	
Pen ñailillo Alfonso, Anita Cristina
2 2:58,62
SSWIM
 13
Moyano, Josefina
3 2:58,66
VITAR
 13
Alberti Mialani, Giuliana
4 3:02,21
WFE
 12
Gomez, Sofia
5 3:09,56
CHIC
 17
Fernandez, Constanza
6 3:13,81
CDEP
 15
Llunell Vilte, Janett
7 3:17,19
CDUC
 15
Pen ña, Beatriz
8 3:18,38
CDEP
 14
Bustos, Renata Paz
*9 3:18,52
EE
 12
Alvarado, Francisca
*9 3:18,52
MAGAL
 13
Cabello, Giuliana
11 3:21,36
LAUTA
 13
Mora, Alen
12 3:22,47
SF
 14
Salazar Reina, Anamaria
13 3:22,57
EE
 16
Alvarado, Pilar
14 3:30,23
ARSU
 15
Acevedo, Paloma
15 3:41,73
YMCA
 13
Madriaga, Paz
16 3:53,10
CDEP
 14
Vergara, Valentina
17 4:04,77
CDEP
 13
Anabalon, Sofia
--- DQ
 #27  Hombres 100 Metro Mariposa
  Nombre         Equipo	
Tiempo de Elim	
SF
 16
Garcia Mavarez, Dario
1 59,15
MAGAL
 16
Cespedes, Diego
2 59,34
EE
 19
Cruz, Emilio
3 59,44
SF
 14
Barreto Garcia, Jose
4 1:00,96
EE
 17
Quiroga, Augusto
5 1:01,22
CDEP
 15
Toledo, Luis
6 1:01,31
SEREN
 13
Sepulveda, Vicente
7 1:02,21
UNIDO
 16
Bastias, Cristobal
8 1:03,77
WFE
 15
Conus, Sergio
9 1:03,83
SI
 15
De la Rivera, Ignacio
10 1:05,06
OHI
 15
Reyes Orellana, Martin
11 1:05,82
MAGAL
 14
Jara, Cristobal
12 1:07,33
MAGAL
 14
Green, Vicente
13 1:08,02
ARSU
 12
Pinto, Benjamin
14 1:09,20
CDUC
 14
Palma, Pablo
15 1:10,15

Club CormupaHY-TEK&#39;s MEET MANAGER 7.0 - 11:58 AM  15/12/2018  Paágina 2
Campeonato Nacional de Clausura Open 2018 - 13/12/2018 a 16/12/2018	
Resultados - Sabado 15 Eliminatorias	
Eliminatorias ...   (#27  Hombres 100 Metro Mariposa) ARENA
 14
Biskupovic, Nicolas
16 1:10,89
VITAR
 13	
Pilquiman Rodriguez, Nicolas
17 1:11,92
CDUC
 16
Ca áceres, Joaquin
18 1:11,99
ARENA
 13
Gomez, David
19 1:13,45
SI
 14
Galleguillos, Julian
20 1:13,46
EE
 14
Wensioe, Martin
21 1:13,64
APS
 16	
Castellanos Villela, Cristian Daniel
22 1:13,98
EE
 13
Badala, Matteo
23 1:14,30
CDEP
 12
Senf, Roberto
24 1:14,80
CDEP
 12
Bustos Garcia, Felipe
25 1:15,27
CHIC
 18
Buono-Core, Diego
26 1:15,67
CDUC
 14
Urrutia, Matias
27 1:18,14
CHIC
 14
Flores, Santiago
28 1:18,28
CDEP
 15
Cardozo, Nicolas
29 1:19,06
YMCA
 14
Sierra, Diego
30 1:22,03
VITAR
 13
Fuenteseca, Leon
31 1:32,07
CDEP
 12
Rubio, Javier
32 1:35,19
CDEP
 13
Dustin, Vera
33 1:37,64
 #28  Mujeres 200 Metro Libre
  Nombre         Equipo	Tiempo de Elim
SI
 21
Valdivia, Mahina
1 2:17,11
EE
 15
Szklaruk-Traipe, Sarah
2 2:17,37
BOYAC
 13
Pavas, Luisa
3 2:18,25
ACADE
 18
Contreras, Gabriela
4 2:18,87
SI
 14
Ramirez, Pia
5 2:19,40
WFE
 14
Klenner, Evaluna
6 2:19,83
CDUC
 17
Bobadilla, Catalina
7 2:26,24
EE
 23
Spuhr, Marianne
8 2:26,64
CDEP
 17	
Hernandez Mun ñoz, Constanza
9 2:27,05
WFE
 14
Llaupe, Janka
10 2:28,55
EE
 12
Engell, Amelie
11 2:29,74
MAGAL
 16
Gamboa, Kamila
12 2:33,03
CDUC
 13
Delgado Noches, Isidora Antonia
13 2:33,04
CDEP
 15
Llunell Vilte, Janett
14 2:33,17
ARSU
 16
Seyssel, Pamela
15 2:34,40
SF
 13
Jara Gallegos, Sofia
16 2:35,51
ACADE
 18
Gonzalez, Mailyn
17 2:36,02
VITAR
 13
Miranda Castro, Jennifer
18 2:36,74
CDEP
 14
Bustos, Renata Paz
19 2:37,72
OHI
 13	
Perromat Villacura, Martina
20 2:39,18
CDUC
 15
Stein, Valentina
21 2:39,21
SF
 15
Contreras Donoso, Maríáa
22 2:41,94
YMCA
 13
Isla, Josefa
23 2:42,46
CDEP
 16
Mun ñoz, Matilde
24 2:43,15
MAGAL
 15
Rojas, Martina
25 2:45,05
POSEI
 13
Hansen, Andra
26 2:45,63
VITAR
 14
Peters Rodriguez, Karen
27 2:45,93
ARSU
 12
Reyes, Gabriela
28 2:46,36
CDEP
 13
Abate, Antonia
29 2:47,45
MAGAL
 13
Romero, Francisca
30 2:48,56
EE
 12
Alvarado, Francisca
31 2:52,18
YMCA
 12
Reyes, Matilda
32 2:58,15AERO
 13
Sepu álveda, Fernanda
33 3:04,54
YMCA
 12
Ortega, Muriel
34 3:05,62
CHIC
 14
Karkling, Irina
35 3:08,35
CHIC
 12
Cerda, Pilar
36 3:08,43
CDEP
 14
Vergara, Valentina
37 3:09,75
CDEP
 14
Tafra, Simone
38 3:11,22	
 #29  Hombres 200 Metro CI
  Nombre         Equipo	Tiempo de Elim
SI
 18
Ahumada, Maximiliano
1 2:17,84
BOYAC
 13
Pantoja, Luis
2 2:20,60
SF
 15
Martinez Rojas, Diego
3 2:21,24
SF
 15
Medina Rios, Samuel
4 2:21,63
MAGAL
 14
Maureira, Javier
5 2:23,57
ARENA
 13
Henriquez, Martin
6 2:24,79
SI
 14
Montagna, Vicente
7 2:25,49
WFE
 15
Martinez, Vicente
8 2:27,10
CHIC
 15
Bobadilla, Patricio
9 2:28,43
WFE
 14
Crhistopher, Conus
10 2:31,28
EE
 13
Salazar, Andoni
11 2:32,10
CDEP
 13
Moreno Paffetti, Martin
12 2:34,43
ARENA
 14
Castillo, Nicolas
13 2:34,56
CDUC
 16
Ca áceres, Joaquin
14 2:34,94
SF
 16
Medina Mujica, Luis
15 2:35,25
ARSU
 13
Gajardo, Juan Pablo
16 2:35,83
ARSU
 18
Gallardo, Joaquin
17 2:36,35
APS
 15	
Gonzalez Moreno, Diego Rodrigo
18 2:36,56
CDEP
 14	
Acevedo  Celedon, Matias
19 2:39,36
APS
 13	
Melin Del Valle, Reiner Aliro
20 2:39,58
CDUC
 16
Luttges, Arturo
21 2:39,93
CDEP
 12
Bruce Robres, Pablo
22 2:41,93
ARSU
 12
Mun ñoz, Elias
23 2:42,64
ARSU
 12
Palma, Francisco
24 2:47,30
ARSU
 12
Pinto, Benjamin
25 2:48,04
CDUC
 14
Schwerter, Federico
26 2:50,00
ACADE
 20
Almonacid, Vicente
27 2:50,87
YMCA
 15
Lobos, David
28 2:55,91
YMCA
 13
Brenat, Diego
29 2:58,57
CDUC
 15
Maturana, Alberto
30 3:02,04
AERO
 16
Sepulveda, Felipe
31 3:12,59
MAGAL
 15
Alvarado, Matias
--- DQ
YMCA
 15
Gonzalez, Felipe
--- DQ
 #30  Mujeres 200 Metro Mariposa
  Nombre         Equipo	Tiempo de Elim	
SI
 26
Perez, Paola
1 2:29,61
SI
 14
Penner, Julianna
2 2:29,90
CDUC
 14
Pacheco, Matilda
3 2:33,94
EE
 18
Salazar, Arantza
4 2:36,30
CDUC
 25
Chamorro, Alejandra
5 2:40,24
MAGAL
 14
Andersen, Sophia
6 2:47,07
CDEP
 13
Mun ñoz Barrios, Emilia
7 2:47,54
WFE
 13
Bratz, Josefa
8 2:54,98
MAGAL
 13
Valdes, Isis
9 2:58,57ACADE
 16
Godoy, Kiara
10 3:00,81
CDEP
 13
Anabalon, Sofia
11 3:23,91	
 #31  Hombres 400 Metro Combinado Relevo
 
  Equipo Relevo	
Tiempo de Elim	
A
EE
1 3:59,58
Varas, Carlos 26 Ortego, Ignacio 17
Cruz, Emilio 19 Quintero, Felipe 19
A
SF
2 4:04,00
Medina Rios, Samuel 15 Medina Mujica, Luis 16
Barreto Garcia, Jose 14 Tapia Aguilera, Pedro 14
A
ARENA
3 4:39,00
Gatica, Leonardo 13 Cubillos, Vicente 14
Biskupovic, Nicolas 14 Henriquez, Martin 13
A
CDEP
4 4:39,34
Moreno Paffetti, Martin 13	
Acevedo  Celedon, Matias 14	
Toledo, Luis 15 Valderrama, Lucas 14
A
MAGAL
5 4:47,00
Alvarado, Matias 15 Green, Vicente 14
Jara, Cristobal 14 Uribe, Hyan 15
A
CHIC
6 4:47,01
Munoz, Benjamin 14 Bobadilla, Patricio 15
Buono-Core, Diego 18 Flores, Santiago 14
A
SI
7 4:47,02
Madariaga, Lucas 14 Montagna, Vicente 14
De la Rivera, Ignacio 15 Molina, Diego 21
A
ARSU
8 4:50,00
Palma, Francisco 12 Gallardo, Joaquin 18
Pinto, Benjamin 12 Gajardo, Juan Pablo 13
A
CDUC
9 4:50,01
Dominguez, Enrique 15 Caáceres, Joaquin 16
Bobadilla, Nicolas 15 Luttges, Arturo 16	
 #32  Mujeres 400 Metro Libre Relevo
 
  Equipo Relevo	
Tiempo de Elim	
A
SI
1 4:09,00
Reyes, Fernanda 14 Valdivia, Mahina 21
Zamorano, Alicia 16 Perez, Paola 26
A
EE
2 4:15,01
Szklaruk-Traipe, Sarah 15 Spuhr, Marianne 23
Engell, Amelie 12 Salazar, Arantza 18
A
CDEP
3 4:24,71	
Hernandez Munñoz, Constanza 17	Anabalon, Sofia 13
Llunell Vilte, Janett 15 Bustos, Renata Paz 14
A
SF
4 4:41,01
Jara Gallegos, Sofia 13
Salazar Reina, Anamaria 14	
Bruno Colmenares, Camila 14	Contreras Donoso, Maríáa 15
A
AERO
5 4:49,00
Rojas, Catalina 14 Ulloa, Monserrat 13
Sepu álveda, Fernanda 13 Ulloa, Beleán 17
A
CDUC
6 4:49,01
Bobadilla, Catalina 17 Pacheco, Matilda 14
Stein, Valentina 15 Chamorro, Alejandra 25
A
MAGAL
7 4:54,00
Gamboa, Kamila 16 Rojas, Martina 15
Valdes, Isis 13 Romero, Francisca 13
A
CHIC
8 4:54,01Club CormupaHY-TEK&#39;s MEET MANAGER 7.0 - 6:47 PM  15/12/2018  Paágina 1
Campeonato Nacional de Clausura Open 2018 - 13/12/2018 a 16/12/2018	
Resultados - Sabado 15 Final	
 #23  Hombres 50 Metro Libre 
  Nombre         Equipo	
Tiempo de Finales	
EE
 26
Varas, Carlos
1 24,29
ACADE
 20
Araya, Vicente
2 24,60
EE
 19
Cruz, Emilio
3 24,65
SF
 19
Perdomo Almiro án, Jose á
4 24,66
EE
 19
Quintero, Felipe
5 25,03
SI
 20
Pinto, Matias
6 25,11
PUC
 22
Saavedra, Diego
7 25,12
SI
 21
Molina, Diego
8 25,13
CDUC
 15
Bobadilla, Nicolas
9 25,58
CDEP
 15
Toledo, Luis
10 25,59
SF
 16
Garcia Mavarez, Dario
11 25,70
SI
 14
Madariaga, Lucas
12 26,03
MAGAL
 14
Maureira, Javier
13 26,26
WFE
 15
Lerzundi, Sebastian
14 26,71
WFE
 15
Conus, Sergio
15 26,99
OHI
 15
Reyes Orellana, Martin
16 27,12
 #24  Mujeres 50 Metro Espalda

  Nombre         Equipo	
Tiempo de Finales	
BOYAC
 15
Melo, Laura
1 30,90
EE
 15
Szklaruk-Traipe, Sarah
2 31,23
EE
 23
Spuhr, Marianne
3 32,59
SF
 13
Pizarro Brito, Isidora
4 32,89
SI
 18
Diaz, Manuela
5 33,14
WFE
 14
Llaupe, Janka
6 34,02
WFE
 15
Martorel, Micaela
7 34,13
CDUC
 14
Pacheco, Matilda
8 35,16
EE
 15
Quiroga, Renata
9 34,87
AERO
 14
Rojas, Catalina
10 35,10
APS
 14	
Buzolic Moreno, Tonka Alejandra
11 35,73
EE
 12
Engell, Amelie
12 35,89
CDUC
 14
Pacheco, Renata
13 36,10
SF
 14	
Bruno Colmenares, Camila
14 36,91
ARSU
 16
Seyssel, Pamela
15 37,69
 #25  Hombres 1500 Metro Libre
  Nombre         Equipo	
Tiempo de Finales	
BOYAC
 20
Ayala, Gustavo
1 16:13,59
SI
 22
Trewhela Pfeifer, Vicente
2 16:23,81
SF
 30
Segovia Ramos, Johndry
3 16:29,54
SF
 13	
Cisternas Gomez, Eduardo
4 16:39,09
SF
 14
Marchesini Ayala, Alejandro
5 17:01,71
BOYAC
 13
Pantoja, Luis
6 17:03,39
CDUC
 15
Dominguez, Enrique
7 18:07,93
ARSU
 17
Sotelo, Antonio
8 18:22,00
VITAR
 15
Pilquiman Rodriguez, Matias
9 18:54,70
SF
 13
Alonso Vasquez, Pablo
10 19:41,49
ARSU
 12
Mun ñoz, Elias
11 20:26,71	
 #26  Mujeres 200 Metro Pecho

  Nombre         Equipo	
Tiempo de Finales	
SI
 14
Reyes, Fernanda
1 2:51,44
OHI
 19	
Pen ñailillo Alfonso, Anita Cristina
2 2:55,10
SSWIM
 13
Moyano, Josefina
3 2:56,65
VITAR
 13
Alberti Mialani, Giuliana
4 2:58,64
WFE
 12
Gomez, Sofia
5 3:10,14
CHIC
 17
Fernandez, Constanza
6 3:15,81
CDUC
 15
Pen ña, Beatriz
7 3:16,02
CDEP
 15
Llunell Vilte, Janett
8 3:19,38
EE
 12
Alvarado, Francisca
9 3:13,39
CDEP
 14
Bustos, Renata Paz
10 3:18,24
SF
 14
Salazar Reina, Anamaria
11 3:19,52
MAGAL
 13
Cabello, Giuliana
12 3:21,52
LAUTA
 13
Mora, Alen
13 3:22,35
EE
 16
Alvarado, Pilar
14 3:32,50
ARSU
 15
Acevedo, Paloma
15 3:39,00
YMCA
 13
Madriaga, Paz
16 3:53,53
 #27  Hombres 100 Metro Mariposa

  Nombre         Equipo	
Tiempo de Finales	
EE
 19
Cruz, Emilio
1 57,43
MAGAL
 16
Cespedes, Diego
2 58,10
SF
 16
Garcia Mavarez, Dario
3 58,34
SF
 14
Barreto Garcia, Jose
4 1:00,25
CDEP
 15
Toledo, Luis
5 1:00,36
SEREN
 13
Sepulveda, Vicente
6 1:01,81
WFE
 15
Conus, Sergio
7 1:03,99
SI
 15
De la Rivera, Ignacio
8 1:04,20
OHI
 15
Reyes Orellana, Martin
9 1:06,78
MAGAL
 14
Jara, Cristobal
10 1:07,10
MAGAL
 14
Green, Vicente
11 1:07,64
ARENA
 14
Biskupovic, Nicolas
12 1:08,85
ARSU
 12
Pinto, Benjamin
13 1:10,35
VITAR
 13	
Pilquiman Rodriguez, Nicolas
14 1:11,74
CDUC
 16
Ca áceres, Joaquin
15 1:11,91
CDUC
 14
Palma, Pablo
--- DQ
 #28  Mujeres 200 Metro Libre
  Nombre         Equipo	
Tiempo de Finales	
EE
 15
Szklaruk-Traipe, Sarah
1 2:09,27
SI
 21
Valdivia, Mahina
2 2:10,76
BOYAC
 13
Pavas, Luisa
3 2:13,12
ACADE
 18
Contreras, Gabriela
4 2:15,61
WFE
 14
Klenner, Evaluna
5 2:17,18
SI
 14
Ramirez, Pia
6 2:18,52
CDUC
 17
Bobadilla, Catalina
7 2:26,43
EE
 23
Spuhr, Marianne
8 2:28,38
WFE
 14
Llaupe, Janka
9 2:25,91
EE
 12
Engell, Amelie
10 2:29,56ARSU
 16
Seyssel, Pamela
11 2:32,02
CDUC
 13	
Delgado Noches, Isidora Antonia
12 2:32,15
MAGAL
 16
Gamboa, Kamila
13 2:32,69
CDEP
 15
Llunell Vilte, Janett
14 2:34,12
SF
 13
Jara Gallegos, Sofia
15 2:34,36
VITAR
 13
Miranda Castro, Jennifer
16 2:37,15
 #29  Hombres 200 Metro CI
  Nombre         Equipo	
Tiempo de Finales
SI
 18
Ahumada, Maximiliano
1 2:12,41
SF
 15
Martinez Rojas, Diego
2 2:12,71
BOYAC
 13
Pantoja, Luis
3 2:15,86
SF
 15
Medina Rios, Samuel
4 2:19,71
MAGAL
 14
Maureira, Javier
5 2:20,70
ARENA
 13
Henriquez, Martin
6 2:24,48
SI
 14
Montagna, Vicente
7 2:25,60
WFE
 15
Martinez, Vicente
8 2:29,06
EE
 13
Salazar, Andoni
9 2:27,36
WFE
 14
Crhistopher, Conus
10 2:27,88
CHIC
 15
Bobadilla, Patricio
11 2:27,91
SF
 16
Medina Mujica, Luis
12 2:31,58
ARENA
 14
Castillo, Nicolas
13 2:31,75
ARSU
 13
Gajardo, Juan Pablo
14 2:34,41
CDEP
 13
Moreno Paffetti, Martin
15 2:34,42
CDUC
 16
Ca áceres, Joaquin
16 2:36,21
 #30  Mujeres 200 Metro Mariposa
  Nombre         Equipo	Tiempo de Finales	
SI
 26
Perez, Paola
1 2:21,09
SI
 14
Penner, Julianna
2 2:29,76
CDUC
 25
Chamorro, Alejandra
3 2:32,75
EE
 18
Salazar, Arantza
4 2:33,81
CDUC
 14
Pacheco, Matilda
5 2:36,32
CDEP
 13
Mun ñoz Barrios, Emilia
6 2:43,82
MAGAL
 14
Andersen, Sophia
7 2:47,88
WFE
 13
Bratz, Josefa
8 2:52,37
MAGAL
 13
Valdes, Isis
9 2:54,21
ACADE
 16
Godoy, Kiara
10 2:55,62
CDEP
 13
Anabalon, Sofia
11 3:15,47
 #31  Hombres 400 Metro Combinado Relevo
 
  Equipo Relevo	
Tiempo de Finales	
A
SF
1 4:02,05
Perdomo Almiro án, Jose á 19 Martinez Rojas, Diego 15
Garcia Mavarez, Dario 16	
Marchesini Ayala, Alejandro 14
A
SI
2 4:12,59
Ahumada, Maximiliano 18 Quiroz, Felipe 22
Molina, Diego 21 Pinto, Matias 20
A
ARENA
3 4:36,92
Gatica, Leonardo 13 Cubillos, Vicente 14
Biskupovic, Nicolas 14 Henriquez, Martin 13

Club CormupaHY-TEK&#39;s MEET MANAGER 7.0 - 6:47 PM  15/12/2018  Paágina 2
Campeonato Nacional de Clausura Open 2018 - 13/12/2018 a 16/12/2018	
Resultados - Sabado 15 Final	
Final - A ...   (#31  Hombres 400 Metro Combinado Relevo) A
CDEP
4 4:37,40
Moreno Paffetti, Martin 13	
Acevedo  Celedon, Matias 14	
Toledo, Luis 15 Valderrama, Lucas 14
A
CDUC
5 4:38,35
Dominguez, Enrique 15 Caáceres, Joaquin 16
Bobadilla, Nicolas 15 Luttges, Arturo 16
A
MAGAL
6 4:38,46
Alvarado, Matias 15 Green, Vicente 14
Jara, Cristobal 14 Uribe, Hyan 15
A
CHIC
7 4:44,90
Munoz, Benjamin 14 Bobadilla, Patricio 15
Buono-Core, Diego 18 Flores, Santiago 14
A
ARSU
8 4:51,72
Palma, Francisco 12 Gallardo, Joaquin 18
Pinto, Benjamin 12 Gajardo, Juan Pablo 13
A
EE
--- DQ
Varas, Carlos 26 Ortego, Ignacio 17
Cruz, Emilio 19 Quintero, Felipe 19	
 #32  Mujeres 400 Metro Libre Relevo
 
  Equipo Relevo	
Tiempo de Finales	
A
SI
1 4:07,21
Reyes, Fernanda 14 Valdivia, Mahina 21
Zamorano, Alicia 16 Perez, Paola 26
A
EE
2 4:13,17
Szklaruk-Traipe, Sarah 15 Spuhr, Marianne 23
Engell, Amelie 12 Salazar, Arantza 18
A
CDUC
3 4:28,61
Bobadilla, Catalina 17 Pacheco, Matilda 14
Stein, Valentina 15 Chamorro, Alejandra 25
A
CDEP
4 4:35,12	
Hernandez Munñoz, Constanza 17	Anabalon, Sofia 13
Llunell Vilte, Janett 15 Bustos, Renata Paz 14
A
SF
5 4:40,54
Jara Gallegos, Sofia 13
Salazar Reina, Anamaria 14	
Bruno Colmenares, Camila 14	Pizarro Brito, Isidora 13
A
AERO
6 4:51,69
Rojas, Catalina 14 Ulloa, Monserrat 13
Sepu álveda, Fernanda 13 Ulloa, Beleán 17
A
MAGAL
7 4:52,35
Gamboa, Kamila 16 Rojas, Martina 15
Valdes, Isis 13 Romero, Francisca 13Club CormupaHY-TEK&#39;s MEET MANAGER 7.0 - 11:17 AM  16/12/2018  Paágina 1
Campeonato Nacional de Clausura Open 2018 - 13/12/2018 a 16/12/2018	
Resultados - Domingo 16 Eliminatorias	
 #33  Mujeres 50 Metro Libre
   Nombre         Equipo	Tiempo de Elim
ACADE
 18
Contreras, Gabriela
1 28,47
VITAR
 19
Videla, Valeria
2 29,29
SI
 16
Zamorano, Alicia
3 29,35
SF
 13
Pizarro Brito, Isidora
4 29,69
CDEP
 17
Cardona, Valeria
5 29,82
AERO
 14
Rojas, Catalina
6 29,84
EE
 23
Spuhr, Marianne
7 29,89
SI
 14
Ramirez, Pia
8 30,28
EE
 17
Carren ño, Angela
9 30,49
POSEI
 14
Quinteros, Elizabeth
10 30,64
CDEP
 15
Llunell Vilte, Janett
11 30,66
MAYOR
 14
Hafon, Gabriela
12 30,78
OHI
 18
Droguett, Sofia
13 30,86
APS
 13	
Ortiz Herna ández, Barbara Aracely
14 30,94
CDUC
 15
Stein, Valentina
15 31,15
CDEP
 17	
Hernandez Mun ñoz, Constanza
16 31,42
CDEP
 14
Bustos, Renata Paz
17 31,54
EE
 14
Bennewitz, Catalina
18 31,70
EE
 15
Quiroga, Renata
19 31,73
ARSU
 16
Seyssel, Pamela
20 31,96
CDUC
 13	
Delgado Noches, Isidora Antonia
21 32,01
WFE
 13
Bratz, Josefa
22 32,03
ACADE
 18
Gonzalez, Mailyn
23 32,07
WFE
 14
Llaupe, Janka
24 32,08
MAGAL
 16
Gamboa, Kamila
25 32,13
AERO
 17
Ulloa, Bele án
26 32,19
CDUC
 15
Orpis, Maria Belen
27 32,42
MAYOR
 16
Valenzuela, Daniela
28 32,60
SF
 15
Contreras Donoso, Maríáa
29 32,70
ARSU
 14
Pulgar, Antonia
30 32,85
ACADE
 16
Godoy, Kiara
31 33,03
VITAR
 14
Peters Rodriguez, Karen
32 33,25
CDEP
 13
Abate, Antonia
33 33,35
CDUC
 15
Puelma, Antonia
34 33,46
YMCA
 13
Isla, Josefa
35 33,64
MAGAL
 13
Romero, Francisca
36 33,68
CDUC
 14
Pacheco, Renata
37 33,74
RECRE
 12
Pizarro, Rafaela
38 33,90
ARSU
 15
Acevedo, Paloma
39 33,94
POSEI
 13
Hansen, Andra
40 34,02
EE
 32
Isaac, Gloria
41 34,03
MAGAL
 15
Rojas, Martina
42 34,50
YMCA
 12
Reyes, Matilda
43 34,55
POSEI
 13
Hansen, Anke
44 34,72
RECRE
 17
Zaror, Katherine
45 34,89
ARSU
 12
Reyes, Gabriela
46 35,09
AERO
 13
Ulloa, Monserrat
47 35,65
CDUC
 15
Pen ña, Beatriz
48 35,93
CDEP
 14
Vergara, Valentina
49 36,18
CDEP
 14
Tafra, Simone
50 36,52
AERO
 13
Sepu álveda, Fernanda
51 37,60
YMCA
 15
Rios, Noribel
52 37,80
RECRE
 15
Ibacache, Sofia
53 38,16YMCA
 12
Ortega, Muriel
54 38,17
EE
 16
Alvarado, Pilar
55 38,30
YMCA
 15
Hidalgo, Thamara
56 39,09
WFE
 15
Martorel, Micaela
--- DQ	
 #34  Hombres 50 Metro Espalda

  Nombre         Equipo	
Tiempo de Elim
ACADE
 20
Araya, Vicente
1 27,46
SI
 18
Ahumada, Maximiliano
2 27,80
PUC
 22
Saavedra, Diego
3 28,42
UNIDO
 22
Quintanilla, Benjamin
4 28,46
SI
 21
Molina, Diego
5 28,55
SF
 14	
Marchesini Ayala, Alejandro
6 29,05
SF
 15
Medina Rios, Samuel
7 29,17
SF
 19
Perdomo Almiro án, Jose á
8 29,25
SF
 16
Garcia Mavarez, Dario
9 29,40
EE
 35
Peruga, Alberto
10 29,41
CHIC
 14
Munoz, Benjamin
11 30,89
WFE
 15
Martinez, Vicente
12 31,09
WFE
 15
Lerzundi, Sebastian
13 31,13
WFE
 15
Orizola, Sebastian
14 32,35
ARENA
 12
Gutierrez, Joaquin
15 32,72
ARENA
 13
Gatica, Leonardo
16 33,54
CDEP
 13
Moreno Paffetti, Martin
17 34,00
CDEP
 12
Bruce Robres, Pablo
18 34,52
ARSU
 12
Palma, Francisco
19 35,42
ARSU
 18
Gallardo, Joaquin
20 35,52
CDUC
 14
Urrutia, Matias
21 35,60
RECRE
 17
Cabezas, Maximiliano
22 35,63
YMCA
 15
Lobos, David
23 36,29
APS
 16
Castellanos Villela, Cristian Daniel
24 36,60
YMCA
 16
Martines, Tomas
25 38,29
CDEP
 15
Medina, Sergio
26 38,34
CDUC
 15
Vargas, Simon
27 38,80
AERO
 18
Ortega, Joaquíán
28 38,89
YMCA
 13
Brenat, Diego
29 39,01
MAYOR
 16
Grob, Toma ás
30 39,40
CDEP
 13
Lorca, Martin
31 39,60
YMCA
 15
Gonzalez, Felipe
32 40,14
YMCA
 14
Sierra, Diego
33 40,72
CHIC
 13
Holmgren, Lukas
34 43,47
MAYOR
 16
Cabrera, Carlos
35 43,56
ARENA
 14
Cubillos, Vicente
--- DQ
 #36  Hombres 200 Metro Pecho

  Nombre         Equipo	
Tiempo de Elim
SF
 15
Martinez Rojas, Diego
1 2:33,14
VALDI
 16
Hansen, Nicolas
2 2:36,45
EE
 17
Ortego, Ignacio
3 2:39,81
EE
 13
Salazar, Andoni
4 2:45,51
APS
 13	
Melin Del Valle, Reiner Aliro
5 2:49,47
CHIC
 15
Bobadilla, Patricio
6 2:50,35
ARSU
 18
Gallardo, Joaquin
7 2:50,41
WFE
 14
Crhistopher, Conus
8 2:50,58
ARENA
 14
Castillo, Nicolas
9 2:51,13
ARSU
 13
Gajardo, Juan Pablo
10 2:56,77
CDEP
 12
Senf, Roberto
11 2:57,39
CDUC
 14
Dufflocq, Julio
12 2:57,96
SF
 16
Medina Mujica, Luis
13 2:58,63
CDEP
 14	
Acevedo  Celedon, Matias
14 2:58,70
CDEP
 14
Valderrama, Lucas
15 3:00,38
AERO
 16
Sepulveda, Felipe
16 3:15,36
CDEP
 12
Bustos Garcia, Felipe
17 3:17,89
CDEP
 15
Castellanos, Cristobal
18 3:30,40
 #37  Mujeres 100 Metro Espalda

  Nombre         Equipo	
Tiempo de Elim	
BOYAC
 15
Melo, Laura
1 1:06,49
EE
 15
Szklaruk-Traipe, Sarah
2 1:07,33
BOYAC
 13
Pavas, Luisa
3 1:09,33
EE
 23
Spuhr, Marianne
4 1:11,90
SF
 13
Pizarro Brito, Isidora
5 1:12,40
CDUC
 14
Pacheco, Matilda
6 1:13,60
WFE
 14
Llaupe, Janka
7 1:13,82
CDUC
 17
Bobadilla, Catalina
8 1:13,94
SI
 18
Diaz, Manuela
9 1:15,12
EE
 15
Quiroga, Renata
10 1:15,58
EE
 12
Engell, Amelie
11 1:16,31
VITAR
 13
Miranda Castro, Jennifer
12 1:18,74
AERO
 14
Rojas, Catalina
13 1:18,92
APS
 14	
Buzolic Moreno, Tonka Alejandra
14 1:19,82
OHI
 18
Droguett, Sofia
15 1:21,00
SF
 14	
Bruno Colmenares, Camila
16 1:21,74
CDEP
 13
Mun ñoz Barrios, Emilia
17 1:23,63
CDUC
 15
Orpis, Maria Belen
18 1:23,66
CDUC
 12
Orpis, Florencia
19 1:24,28
SF
 15
Palma Gajardo, Daniela
20 1:25,80
ACADE
 18
Mun ñoz, Valentina
21 1:26,29
ARSU
 14
Pulgar, Antonia
22 1:27,86
CDEP
 13
Abate, Antonia
*23 1:28,37
CDEP
 15
Zavala, Aranzazu
*23 1:28,37
EE
 12
Alvarado, Francisca
25 1:28,78
AERO
 13
Ulloa, Monserrat
26 1:30,80
YMCA
 13
Isla, Josefa
27 1:31,97
ARSU
 12
Reyes, Gabriela
28 1:35,87
AERO
 13
Sepu álveda, Fernanda
29 1:38,89
YMCA
 12
Ortega, Muriel
30 1:38,91
YMCA
 15
Rios, Noribel
31 1:39,95
CHIC
 12
Cerda, Pilar
32 1:40,79
YMCA
 15
Hidalgo, Thamara
33 1:41,95
CDEP
 14
Vergara, Valentina
34 1:42,38
CDUC
 14
Pacheco, Renata
--- DQ
 #38  Hombres 100 Metro Libre

  Nombre         Equipo	
Tiempo de Elim	
SI
 20
Pinto, Matias
1 54,14
EE
 26
Varas, Carlos
2 54,30
EE
 19
Cruz, Emilio
3 54,37

Club CormupaHY-TEK&#39;s MEET MANAGER 7.0 - 11:17 AM  16/12/2018  Paágina 2
Campeonato Nacional de Clausura Open 2018 - 13/12/2018 a 16/12/2018	
Resultados - Domingo 16 Eliminatorias	
Eliminatorias ...   (#38  Hombres 100 Metro Libre) ACADE
 20
Araya, Vicente
4 54,57
SF
 16
Garcia Mavarez, Dario
5 55,12
SF
 19
Perdomo Almiro án, Jose á
6 55,28
SI
 14
Madariaga, Lucas
7 55,35
SF
 14	
Marchesini Ayala, Alejandro
8 55,36
MAGAL
 16
Cespedes, Diego
9 55,38
CDUC
 15
Bobadilla, Nicolas
10 55,93
CDEP
 15
Toledo, Luis
11 56,11
SSWIM
 21
Pereira, Daniel
12 56,12
EE
 19
Quintero, Felipe
13 56,74
MAGAL
 14
Maureira, Javier
14 57,15
EE
 35
Peruga, Alberto
15 58,12
SF
 16
Ortiz Mun ñoz, Vicente
16 58,40
CHIC
 14
Munoz, Benjamin
17 58,65
EE
 18
Lechuga, Claudio
*18 58,91
ARSU
 17
Sotelo, Antonio
*18 58,91
Desempate Requerido SF
 14
Barreto Garcia, Jose
20 58,96
OHI
 15
Reyes Orellana, Martin
21 59,15
ARENA
 13
Henriquez, Martin
22 59,51
WFE
 15
Lerzundi, Sebastian
23 59,73
MAGAL
 18
Tapia, Dusan
24 59,74
RECRE
 13
Aviles, Alonso
25 1:00,12
WFE
 15
Martinez, Vicente
26 1:00,62
VITAR
 15
Pilquiman Rodriguez, Matias
27 1:00,71
ARENA
 14
Biskupovic, Nicolas
28 1:00,82
EE
 16
Fernandez, Vicente
29 1:00,90
WFE
 14
Franco, Guillermo
30 1:00,93
MAGAL
 15
Uribe, Hyan
31 1:00,95
CDUC
 15
Dominguez, Enrique
32 1:01,01
RECRE
 17
Cabezas, Maximiliano
33 1:01,08
MAGAL
 14
Jara, Cristobal
34 1:01,81
CDEP
 14
Valderrama, Lucas
35 1:02,03
CDUC
 16
Luttges, Arturo
36 1:02,40
MAYOR
 17
Gonzalez, Rafael
37 1:02,73
WFE
 15
Orizola, Sebastian
38 1:03,09
CDEP
 15
Cardozo, Nicolas
39 1:03,16
WFE
 14
Crhistopher, Conus
40 1:03,36
ARSU
 14
Cevo, Enzo
41 1:03,63
ARENA
 12
Gutierrez, Joaquin
42 1:03,68
APS
 16	
Castellanos Villela, Cristian Daniel
43 1:03,95
ARENA
 12
Gatica, Cristobal
44 1:04,30
YMCA
 15
Lobos, David
45 1:04,45
CDEP
 13
Moreno Paffetti, Martin
46 1:04,47
CDUC
 16
Ca áceres, Joaquin
47 1:04,50
SI
 14
Galleguillos, Julian
48 1:04,76
ARENA
 13
Gatica, Leonardo
49 1:05,05
VITAR
 13	
Pilquiman Rodriguez, Nicolas
50 1:05,24
AERO
 18
Ortega, Joaquíán
51 1:05,59
MAYOR
 16
Bruce, Vicente
52 1:06,16
ARSU
 12
Pinto, Benjamin
53 1:06,37
MAGAL
 15
Valenzuela, Joaquin
54 1:06,39
MAYOR
 16
Grob, Toma ás
55 1:06,65
EE
 13
Badala, Matteo
56 1:06,66
SF
 15	
Contreras Donoso, Marco
57 1:06,95
EE
 14
Wensioe, Martin
58 1:07,00
CDUC
 14
Palma, Pablo
59 1:07,25
CDUC
 14
Urrutia, Matias
60 1:07,28
CDUC
 14
Schwerter, Federico
61 1:07,58
SF
 14	
Braithwaite Danus, Sebastian
62 1:07,60
VITAR
 13
Venegas Perez, Martin
63 1:07,96
YMCA
 13
Brenat, Diego
64 1:09,16
CDUC
 13
Pedemonte, Facundo
65 1:09,70
VITAR
 12
Ramos, Francisco
66 1:09,81
YMCA
 16
Martines, Tomas
67 1:10,05
CHIC
 14
Flores, Santiago
68 1:10,06
ACADE
 20
Almonacid, Vicente
69 1:10,10
VITAR
 13
Fuenteseca, Leon
70 1:10,73
CDEP
 12
Rubio, Javier
71 1:10,99
CDUC
 15
Vargas, Simon
72 1:11,69
YMCA
 14
Sierra, Diego
73 1:11,90
SF
 14
Nun ñez Tobar, Nahuel
74 1:12,68
CHIC
 13
Atenas, Juan
75 1:13,37
CDEP
 15
Medina, Sergio
76 1:13,88
EE
 12
Luscher, Felipe
77 1:14,09
CDUC
 15
Maturana, Alberto
78 1:14,52
CDEP
 13
Dustin, Vera
79 1:15,42
ARSU
 18
Gallardo, Joaquin
80 1:17,73
MAYOR
 16
Cabrera, Carlos
81 1:17,86
CDEP
 13
Lorca, Martin
82 1:17,88
AERO
 16
Sepulveda, Felipe
83 1:18,40
CHIC
 13
Holmgren, Lukas
84 1:18,63
EE
 14
Jung, Tomas
--- DQ
CDEP
 14
Baeza, Rafael
--- DQ
CDEP
 14
Elgueta, Marco Antonio
--- DQ
WFE
 15
Conus, Sergio
--- DQ
 #39  Mujeres 100 Metro Pecho
  Nombre         Equipo	Tiempo de Elim
BOYAC
 15
Melo, Laura
1 1:17,49
SI
 26
Perez, Paola
2 1:20,04
OHI
 16
Vega Alarcon, Catalina
3 1:21,64
SSWIM
 13
Moyano, Josefina
4 1:22,66
EE
 14
Bennewitz, Catalina
5 1:23,01
WFE
 12
Gomez, Sofia
6 1:28,82
MAGAL
 14
Andersen, Sophia
7 1:29,49
EE
 12
Alvarado, Francisca
8 1:30,19
SF
 14
Salazar Reina, Anamaria
9 1:30,44
CHIC
 17
Fernandez, Constanza
10 1:31,97
CDEP
 17
Cardona, Valeria
11 1:32,73
CDUC
 15
Pen ña, Beatriz
12 1:33,45
LAUTA
 13
Mora, Alen
13 1:34,10
CDEP
 15
Llunell Vilte, Janett
14 1:34,16
MAGAL
 13
Cabello, Giuliana
15 1:34,31
CDUC
 12
Orpis, Florencia
16 1:34,57
CDEP
 14
Bustos, Renata Paz
17 1:34,90
CDEP
 17	
Hernandez Mun ñoz, Constanza
18 1:36,69
EE
 16
Alvarado, Pilar
19 1:37,75
ARSU
 15
Acevedo, Paloma
20 1:39,96
RECRE
 17
Zaror, Katherine
21 1:42,03
YMCA
 12
Reyes, Matilda
22 1:48,64CHIC
 14
Karkling, Irina
23 2:07,64
POSEI
 13
Hansen, Anke
--- DQClub CormupaHY-TEK&#39;s MEET MANAGER 7.0 - 6:08 PM  16/12/2018  Paágina 1
Campeonato Nacional de Clausura Open 2018 - 13/12/2018 a 16/12/2018	
Resultados - Domingo 16 Final	
 #33  Mujeres 50 Metro Libre 
  Nombre         Equipo	
Tiempo de Finales	
ACADE
 18
Contreras, Gabriela
1 28,31
SI
 16
Zamorano, Alicia
2 29,03
VITAR
 19
Videla, Valeria
3 29,10
SF
 13
Pizarro Brito, Isidora
4 29,63
AERO
 14
Rojas, Catalina
5 29,75
CDEP
 17
Cardona, Valeria
6 29,88
SI
 14
Ramirez, Pia
7 30,27
POSEI
 14
Quinteros, Elizabeth
8 30,32
MAYOR
 14
Hafon, Gabriela
9 30,24
CDEP
 15
Llunell Vilte, Janett
10 30,47
APS
 13	
Ortiz Herna ández, Barbara Aracely
11 30,95
EE
 14
Bennewitz, Catalina
12 30,98
CDUC
 15
Stein, Valentina
13 31,60
EE
 15
Quiroga, Renata
14 31,62
CDEP
 14
Bustos, Renata Paz
15 31,68
 #34  Hombres 50 Metro Espalda

  Nombre         Equipo	
Tiempo de Finales	
SI
 18
Ahumada, Maximiliano
1 27,40
ACADE
 20
Araya, Vicente
2 27,41
PUC
 22
Saavedra, Diego
3 28,04
SI
 21
Molina, Diego
4 28,09
UNIDO
 22
Quintanilla, Benjamin
5 28,24
SF
 15
Medina Rios, Samuel
6 28,80
SF
 14	
Marchesini Ayala, Alejandro
7 29,00
EE
 35
Peruga, Alberto
8 29,60
CHIC
 14
Munoz, Benjamin
9 30,93
ARENA
 12
Gutierrez, Joaquin
10 33,42
ARENA
 13
Gatica, Leonardo
11 33,80
CDEP
 12
Bruce Robres, Pablo
12 34,28
 #35  Mujeres 1500 Metro Libre

  Nombre         Equipo	
Tiempo de Finales	
SI
 21
Valdivia, Mahina
1 18:31,37
SI
 14
Penner, Julianna
2 18:40,93
VITAR
 13
Alberti Mialani, Giuliana
3 19:33,22
APS
 14	
Buzolic Moreno, Tonka Alejandra
4 19:57,43
CDEP
 13
Anabalon, Sofia
5 20:19,47
MAGAL
 13
Valdes, Isis
6 20:53,97
SF
 13
Jara Gallegos, Sofia
7 21:05,43
 #36  Hombres 200 Metro Pecho

  Nombre         Equipo	
Tiempo de Finales	
VALDI
 16
Hansen, Gerhart
1 2:33,38
EE
 17
Ortego, Ignacio
2 2:35,25
EE
 13
Salazar, Andoni
3 2:42,70
CHIC
 15
Bobadilla, Patricio
4 2:47,69
WFE
 14
Crhistopher, Conus
5 2:48,91
ARENA
 14
Castillo, Nicolas
6 2:48,92
APS
 13	
Melin Del Valle, Reiner Aliro
7 2:50,02
ARSU
 18
Gallardo, Joaquin
8 2:52,28
SF
 16
Medina Mujica, Luis
9 2:47,61
CDEP
 14	
Acevedo  Celedon, Matias
10 2:56,07
CDUC
 14
Dufflocq, Julio
11 2:56,31
CDEP
 12
Senf, Roberto
12 2:56,88
CDEP
 14
Valderrama, Lucas
13 2:59,61
AERO
 16
Sepulveda, Felipe
14 3:12,55
CDEP
 12
Bustos Garcia, Felipe
15 3:16,18
CDEP
 15
Castellanos, Cristobal
16 3:30,84
 #37  Mujeres 100 Metro Espalda

  Nombre         Equipo	
Tiempo de Finales	
BOYAC
 15
Melo, Laura
1 1:05,05
EE
 15
Szklaruk-Traipe, Sarah
2 1:06,68
BOYAC
 13
Pavas, Luisa
3 1:08,43
EE
 23
Spuhr, Marianne
4 1:10,07
SF
 13
Pizarro Brito, Isidora
5 1:11,66
WFE
 14
Llaupe, Janka
6 1:12,18
CDUC
 14
Pacheco, Matilda
7 1:12,68
CDUC
 17
Bobadilla, Catalina
8 1:14,84
EE
 15
Quiroga, Renata
9 1:14,75
EE
 12
Engell, Amelie
10 1:14,92
VITAR
 13
Miranda Castro, Jennifer
11 1:18,30
AERO
 14
Rojas, Catalina
12 1:18,64
APS
 14	
Buzolic Moreno, Tonka Alejandra
13 1:20,37
SF
 14	
Bruno Colmenares, Camila
14 1:20,43
CDEP
 13
Mun ñoz Barrios, Emilia
15 1:22,54
CDUC
 15
Orpis, Maria Belen
16 1:24,25
 #38  Hombres 100 Metro Libre
  Nombre         Equipo	Tiempo de Finales	
EE
 26
Varas, Carlos
1 52,72
EE
 19
Cruz, Emilio
2 53,45
SI
 20
Pinto, Matias
3 53,71
ACADE
 20
Araya, Vicente
4 53,96
SI
 14
Madariaga, Lucas
5 54,71
CDUC
 15
Bobadilla, Nicolas
6 55,83
CDEP
 15
Toledo, Luis
7 56,19
MAGAL
 16
Cespedes, Diego
--- DQ
MAGAL
 14
Maureira, Javier
9 57,07
SF
 16
Ortiz Mun ñoz, Vicente
10 58,13
SF
 14
Barreto Garcia, Jose
11 58,40
MAGAL
 18
Tapia, Dusan
12 59,30
OHI
 15
Reyes Orellana, Martin
13 59,99
CHIC
 14
Munoz, Benjamin
--- DQ
 #39  Mujeres 100 Metro Pecho
  Nombre         Equipo	
Tiempo de Finales	
BOYAC
 15
Melo, Laura
1 1:15,93
SI
 26
Perez, Paola
2 1:18,98
EE
 14
Bennewitz, Catalina
3 1:20,86
SSWIM
 13
Moyano, Josefina
4 1:21,07
OHI
 16
Vega Alarcon, Catalina
5 1:22,01
WFE
 12
Gomez, Sofia
6 1:26,31
EE
 12
Alvarado, Francisca
7 1:28,53
MAGAL
 14
Andersen, Sophia
8 1:30,54
SF
 14
Salazar Reina, Anamaria
9 1:30,91
CDUC
 12
Orpis, Florencia
10 1:32,78
CDEP
 14
Bustos, Renata Paz
11 1:33,66
CDEP
 15
Llunell Vilte, Janett
12 1:34,01
MAGAL
 13
Cabello, Giuliana
13 1:34,29
EE
 16
Alvarado, Pilar
14 1:35,49
CDUC
 15
Pen ña, Beatriz
--- DQ	
 #40  Hombres 400 Metro CI

  Nombre         Equipo	
Tiempo de Finales	
SF
 15
Martinez Rojas, Diego
1 4:48,01
SI
 18
Ahumada, Maximiliano
2 4:58,37
SF
 15
Medina Rios, Samuel
3 4:59,53
CDUC
 15
Bobadilla, Nicolas
4 5:01,79
ARENA
 13
Henriquez, Martin
5 5:06,38
SI
 14
Montagna, Vicente
6 5:06,47
MAGAL
 15
Alvarado, Matias
7 5:11,61
SI
 14
Marin, Santiago
8 5:14,82
CHIC
 15
Bobadilla, Patricio
9 5:18,31
EE
 13
Salazar, Andoni
10 5:28,22
MAGAL
 14
Green, Vicente
11 5:28,87
ARENA
 14
Castillo, Nicolas
12 5:30,65
ARSU
 12
Mun ñoz, Elias
13 5:36,56
APS
 15	
Gonzalez Moreno, Diego Rodrigo
14 5:38,36
CDEP
 12
Bruce Robres, Pablo
15 5:40,45
CDEP
 12
Senf, Roberto
16 5:41,11
SF
 13
Alonso Vasquez, Pablo
17 5:42,78
ARENA
 13
Gomez, David
18 5:51,53
BOYAC
 13
Pantoja, Luis
--- DQ
ARSU
 13
Gajardo, Juan Pablo
--- DQ
 #41  Mujeres 400 Metro Combinado Relevo 
  Equipo Relevo	
Tiempo de Finales	
A
EE
1 4:36,30
Szklaruk-Traipe, Sarah 15 Bennewitz, Catalina 14
Salazar, Arantza 18 Spuhr, Marianne 23
A
SI
2 4:39,41
Diaz, Manuela 18 Perez, Paola 26
Penner, Julianna 14 Valdivia, Mahina 21
A
CDUC
3 4:57,21
Bobadilla, Catalina 17 Chamorro, Alejandra 25
Pacheco, Matilda 14 Stein, Valentina 15
A
CDEP
4 5:11,92
Anabalon, Sofia 13 Bustos, Renata Paz 14
Mun ñoz Barrios, Emilia 13 Cardona, Valeria 17
A
SF
5 5:21,91	
Bruno Colmenares, Camila 14	Salazar Reina, Anamaria 14	
Pizarro Brito, Isidora 13Jara Gallegos, Sofia 13

Club CormupaHY-TEK&#39;s MEET MANAGER 7.0 - 6:08 PM  16/12/2018  Paágina 2
Campeonato Nacional de Clausura Open 2018 - 13/12/2018 a 16/12/2018	
Resultados - Domingo 16 Final	
 #42  Hombres 400 Metro Libre Relevo  
  Equipo Relevo	
Tiempo de Finales	
SI
1 3:34,58
Molina, Diego 21 Ahumada, Maximiliano 18
Madariaga, Lucas 14 Pinto, Matias 20
A
EE
2 3:35,54
Cruz, Emilio 19 Quintero, Felipe 19
Quiroga, Augusto 17 Varas, Carlos 26
A
SF
3 3:37,96
Martinez Rojas, Diego 15 Garcia Mavarez, Dario 16	
Marchesini Ayala, Alejandro 14	Perdomo Almiroán, Jose á 19
A
CDUC
4 4:01,00
Dominguez, Enrique 15 Caáceres, Joaquin 16
Luttges, Arturo 16 Bobadilla, Nicolas 15
A
CDEP
5 4:05,82
Toledo, Luis 15 Valderrama, Lucas 14
Senf, Roberto 12
Acevedo  Celedon, Matias 14
A
ARENA
6 4:06,83
Henriquez, Martin 13 Gutierrez, Joaquin 12
Castillo, Nicolas 14 Biskupovic, Nicolas 14
A
CHIC
7 4:23,62
Atenas, Juan 13 Flores, Santiago 14
Bobadilla, Patricio 15 Munoz, Benjamin 14<br><br><br><br>";

$text = str_replace("Edad\n", "", $text);
$text = str_replace("Edad", "", $text);
$text = str_replace("Equipo", "", $text);
$text = str_replace("Nombre", "", $text);
$text = str_replace("Tiempo de Finales", "", $text);
$text = str_replace("Tiempo de Finales\n", "", $text);
$text = str_replace("Tiempo de Elim\n", "", $text);
$text = str_replace("Tiempo de Elim", "", $text);
$text = str_replace("Tiempo para Sembrado\n", "", $text);
$text = str_replace("Tiempo para Sembrado", "", $text);
$text = str_replace("Puntos\n", "", $text);
$text = str_replace("Puntos", "", $text);
$text = str_replace("Finales\n", "", $text);
$text = str_replace("Finales", "", $text);
$text = str_replace("Resultados", "", $text);


$nombre_archivo = "resultados/logs_".$clave_st.".txt"; 
 
    if(file_exists($nombre_archivo))
    {
        //$mensaje = "El Archivo $nombre_archivo se ha modificado";
    }
 
    else
    {
        //$mensaje = "El Archivo $nombre_archivo se ha creado";
    }
 
    if($archivo = fopen($nombre_archivo, "a"))
    {
        if(fwrite($archivo, $text))
        {
            echo "Se ha ejecutado correctamente";
        }
        else
        {
            echo "Ha habido un problema al crear el archivo";
        }
 
        fclose($archivo);
    }

    
    $file = fopen($nombre_archivo, "r") or exit("Unable to open file!");
//Output a line of the file until the end is reached
    $contador = 0;
    $linea1 = '';
    $linea2 = 'aaaa';
     $formato = 1;
while(!feof($file))
{
   // $formato = 1;
    $contador ++;
    $linea = trim(fgets($file));
    
    if ($contador == 1) {
        $linea1 = $linea;
    } else if ($contador == 2) {
        $linea2 = $linea;        
    }
    
    $pos = strpos($linea, "HY-TEK");
    $pos1 = strpos($linea, $linea2);

    if ($pos === false and $pos1 === false) {
        $revisor = trim ( $linea );
        //echo "---".$revisor."---<br />";
        if (empty($revisor)) {
            //echo "<strong>iiii".$linea. "</strong>";
        } else {
            //echo "\"".$revisor. "\"<br />";
            $pos2 = strpos($linea, "Evento");  
            $pos2x = strpos($linea, "#");  
            if ($pos2 !== false or $pos2x !== false) {
                 $formato = 1;
              $evento = $linea;
              $control = 1;
              $sql = "INSERT INTO sys_Evento (CompetenciaId, Nombre) VALUES ('$id_campeonato', '$evento')";
                echo $sql;
                    /*$result = mysqli_query($connection, $sql);
                $evento_id = mysqli_insert_id($connection);*/
            } else {
               //
              if ($control <= 4) {
                  if ($control == 1) {
                      $formato = 1;
                      if(is_numeric ( $linea )) {
                          echo "<br><strong>es un numero</strong><br>";
                          $formato = 2;
                          
                      }
                  }
                  
                  
                 echo "<br>formato: ".$formato."<br>";
                  if ($formato === 1) {
                     
                     if ($control == 1) {
                        $club = $linea;
                        //echo "<br><br><strong>linea 1</strong> \"".$linea."\"<br>";
                     } else if ($control == 2) {
                        // echo "<strong>linea 2</strong> ".$linea."<br>";
                        $edad = $linea; 
                     } else if ($control == 3) {
                        // echo "<strong>linea 3</strong> ".$linea."<br>";
                        $nadador = $linea; 
                     } else if ($control == 4) {
                        // echo "<strong>linea 4</strong> ".$linea."<br>";
                        $tiempo1 = explode(" ", $linea);
                        $lugar = $tiempo1[0];
                        $tiempo = $tiempo1[1];
                        $puntos = $tiempo1[2];
                        $control = 0;
                     }
                  } else {
                      if ($control == 4) {
                        $club = $linea;
                       // echo "<br><br><strong>linea 4</strong> \"".$linea."\"<br>";
                     } else if ($control == 1) {
                        // echo "<strong>linea 1</strong> ".$linea."<br>";
                        $edad = $linea; 
                     } else if ($control == 2) {
                        // echo "<strong>linea 2</strong> ".$linea."<br>";
                        $nadador = $linea; 
                     } else if ($control == 3) {
                        // echo "<strong>linea 3</strong> ".$linea."<br>";
                        $tiempo1 = explode(" ", $linea);
                        $lugar = $tiempo1[0];
                        $tiempo = $tiempo1[1];
                        $puntos = $tiempo1[2];
                        $control = 0;
                     }
                      
                  }
                  
                  
                  

              } 
              
              if ($control == 0) {
                  $pos4 = strpos($evento, "Relevo");  
                if ($pos4 === false) {
                  $sql0 = "SELECT id, Club FROM sys_Clubes WHERE Club = '$club' LIMIT 1";
                    $result0 = mysqli_query($connection, $sql0);

                    if (mysqli_num_rows($result0) > 0) {
                        // output data of each row
                        while($row = mysqli_fetch_assoc($result0)) {
                            $id_club = $row["id"];
                        }
                    } else {
                        $sql1 = "INSERT INTO sys_Clubes (Club) "
                            . "VALUES ('$club')";
                        echo $sql1."<br>";
                           $result1 = mysqli_query($connection, $sql1);
                            $id_club = mysqli_insert_id($connection);
                    }
                    
                  echo "Evento:".$evento."<br />Club: ".$club."<br />Edad: ".$edad."<br />Nadador: ".$nadador."<br />Lugar: ".$lugar."<br />Tiempo: ".$tiempo."<br /><br />";
                  $sql = "INSERT INTO sys_Competidor (EventoId, Nombre, club_id, Edad, Posicion, TiempoSembrado, TiempoFinal, Puntos) "
                            . "VALUES ({$evento_id}, "
                            . "'$nadador', "
                            . "'$id_club', "
                            . "$edad, "
                            . "$lugar, "
                            . "'', "
                            . "'$tiempo', "
                            . "'$puntos')";
                            echo $sql;
                    //$result = mysqli_query($connection, $sql);
                }
              }
              $control ++;
            }
        }
        
      
    }
    
    
    

}
fclose($file);


?>