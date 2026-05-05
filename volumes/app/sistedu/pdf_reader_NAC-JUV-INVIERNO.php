<?php error_reporting(E_ALL);
ini_set('display_errors', '1');

define('DB_NAME', 'xaguas_cnpa');
define('DB_USER', 'xaguas_cnpa');
define('DB_PASSWORD', '15230574');
define('DB_HOST', 'localhost');
$id_campeonato = 31;

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$connection) $success = false;
    
    $connection->set_charset("utf8");

    include 'vendor/autoload.php';
 
 
// Parse pdf file and build necessary objects.
$parser = new \Smalot\PdfParser\Parser();
$pdf    = $parser->parseFile('document1.pdf');
$clave_st = uniqid();
 
/*$pages  = $pdf->getPages();
 
// Loop over each page to extract text.
foreach ($pages as $page) {
    echo $page->getText();
}*/
//$text = $pdf->getText();

//echo $text."<br><br><br><br>";


$text = "
Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 1
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
 Evento 1  Hombres 13-14 50 CL Metro Estilo de Mariposa    Equipo	Nombre	Tiempo de Finales	
MAYOR
 14
Lazzerini, Mariano
1 26,81  9
SEREN
 14
Sepulveda, Vicente
2 28,03  7
UNIDO
 14
Lim, Sean
3 28,46  6
TEMUC
 14
Gesche, Diego
4 28,72  5
MAYOR
 14
Menendez, Jose
5 28,75  4
EE
 14
Estevez, Simon
6 29,22  3
MAGAL
 14
Jara, Cristobal
7 29,33  2
ARENA
 14
Biscupovic, Nicolas
8 29,70  1
 Evento 1  Hombres 13-14 50 CL Metro Estilo de Mariposa
   Equipo	Nombre Tiempo de Finales
MAYOR
 14
Lazzerini, Mariano
1 26,97q
MAYOR
 14
Menendez, Jose
2 28,52q
UNIDO
 14
Lim, Sean
3 28,56q
EE
 14
Estevez, Simon
4 28,72q
SEREN
 14
Sepulveda, Vicente
5 28,74q
TEMUC
 14
Gesche, Diego
6 28,96q
ARENA
 14
Biscupovic, Nicolas
7 29,25q
MAGAL
 14
Jara, Cristobal
8 29,29q
AUTO
 13
Hewstone, Felipe
9 29,68
SSWIM
 14
Pavez, Martíán
10 30,18
WFE
 14
Crhistopher, Conus
11 30,47
TMF
 13
Urutia, Edgar
12 30,48
ARSU
 13
Mun ñoz, Bruno
13 30,56
SF
 14
Tapia Aguilera, Pedro
14 30,73
ARENA
 14
Cubillos, Vicente
15 30,89
ATAL
 13
Sepu álveda, Cristobal
16 30,99
ATAL
 13
Sanchez, Sebastian
17 31,26
MAKO
 14
Parra, Andres
18 31,28
MAKO
 13
Barraza, Bruno
19 31,37
ATAL
 14
Esteves, Emilio
20 31,43
WFE
 14
Franco, Guillermo
21 31,51
COQUI
 14
Calfupan, Cristian
22 31,53
MAKO
 13
Pen ña, Martin
23 31,71
CDUC
 14
Palma, Pablo
24 31,74
VICEN
 14
Donoso, Cristobal
25 31,78
MAGAL
 14
Berrios, Reinaldo
*26 31,89
SI
 13
Diaz, Carlos
*26 31,89
MAGAL
 13
Green, Vicente
28 31,92
MAYOR
 13
Barriga, Sebastian
29 32,02
MAGAL
 13
Salazar, Alonso
30 32,08
SSWIM
 14
Annaratone, Daniel
31 32,32
HUMAN
 14
Henriquez, Cristian
32 32,39
SI
 14
Galleguillos, Julian
33 32,85
VICEN
 14
Pacheco, Fernando
34 32,93
ARAU
 14
Olivares, Gabriel
35 33,05
VITAC
 13
Pilquiman, Nicolas
36 33,58
ADESE
 14
Villanueva, Enrique
37 33,78
ARSU
 13
Caro, Ma áximo
38 34,00
SEREN
 13
Vega, Cristobal
39 34,20
APS
 14
Romero Brizuen ño, Juan Pablo Sebastian
40 34,30
CDUC
 14
Urrutia, Matias
41 34,86 EE
 14
Wensioe, Martin
42 35,46
MAKO
 13
Carrasco, Martin
43 38,22	
 Evento 2  Hombres 15-16 50 CL Metro Estilo de Mariposa
   Equipo	Nombre	Tiempo de Finales	
UNIDO
 16
Schnapp, Benjamin
1 25,82  9
MAYOR
 16
Olivos, Lucas
2 26,84  7
MAGAL
 16
Cespedes, Diego
3 26,86  6
CDEP
 15
Toledo, Luis
4 27,07  5
DPA
 16
Jimenez, Felipe
5 28,03  4
ATAL
 16
Mena, Santiago
6 28,11  3
WFE
 15
Conus, Sergio
7 28,39  2
SF
 16
Bastias Barra, Cristobal
8 28,98  1
 Evento 2  Hombres 15-16 50 CL Metro Estilo de Mariposa
   Equipo	Nombre Tiempo de Finales
UNIDO
 16
Schnapp, Benjamin
1 26,02q
MAYOR
 16
Olivos, Lucas
2 27,09q
CDEP
 15
Toledo, Luis
3 27,60q
MAGAL
 16
Cespedes, Diego
4 27,87q
DPA
 16
Jimenez, Felipe
5 28,15q
WFE
 15
Conus, Sergio
6 28,27q
ATAL
 16
Mena, Santiago
7 28,80q
SF
 16
Bastias Barra, Cristobal
8 28,93q
SF
 16
Ortiz Mun ñoz, Vicente
9 28,96
VIN ÑA
 16
Martinez, Alexandro
10 29,67
WFE
 15
Orizola, Sebastian
11 29,76
WFE
 15
Bratz, Octavio
12 29,89
SEREN
 15
Bernal, Pacual
13 29,91
SI
 15
De la Rivera, Ignacio
14 30,04
ARAU
 15
Araya, Pablo
15 30,20
MAYOR
 16
Olivos, Joaquin
16 30,26
APS
 16
Castellanos Villela, Cristian Daniel
17 30,31
HUMAN
 16
Camus, Patricio
18 30,35
SEREN
 15
Navia, Matias
19 30,38
CDUC
 16
Luttges, Arturo
20 30,59
SSWIM
 15
Baeza, Nicola ás
*21 30,60
HUMAN
 15
Agurto, Lucas
*21 30,60
ARSU
 16
Pfiffer, Martíán
23 30,62
ARENA
 15
Gutierrez, Nicolas
24 30,75
ARAU
 15
Carvajal, Luciano
25 30,95
CDUC
 16
Ca áceres, Joaquin
26 31,41
SEREN
 16
Bustos, Felipe
27 31,90
AUTO
 16
Barrera, Juan
28 32,17
MASSS
 16
Guarin, David
29 32,19
CDUC
 16
Romero, Diego
30 32,46
MAKO
 16
Araya, Felipe
31 32,51
AUTO
 15
Zepeda, Agustin
32 33,28
AMARU
 16
Meza, Pablo
33 33,96
VICEN
 15
Gonzalez, Jorge
34 34,62
MAGAL
 15
Valenzuela, Joaquin
35 34,63

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 2
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
 Evento 3  Hombres 17-99 50 CL Metro Estilo de Mariposa
 Equipo	Nombre	Tiempo de Finales	
MAKO
 30
Elliot, Oliver
1 24,97  9
MAYOR
 18
Araya, Gabriel
2 26,08  7
MAYOR
 23
Sepulveda, Joaquin
3 26,12  6
EE
 17
Quiroga, Augusto
4 26,54  5
MAYOR
 17
Alvarez, Ignacio
5 26,74  4
UNIDO
 21
Quintanilla, Benjamin
6 26,85  3
UNIDO
 18
Bustamante, Hugo
7 27,26  2
SF
 24
Perey Fica, Javier
8 27,39  1
 Evento 3  Hombres 17-99 50 CL Metro Estilo de Mariposa
   Equipo	Nombre Tiempo de Finales
MAYOR
 18
Araya, Gabriel
1 26,75q
EE
 17
Quiroga, Augusto
*2 26,77q
MAYOR
 17
Alvarez, Ignacio
*2 26,77q
UNIDO
 21
Quintanilla, Benjamin
4 26,83q
MAKO
 30
Elliot, Oliver
5 26,84q
UNIDO
 18
Bustamante, Hugo
6 26,86q
MAYOR
 23
Sepulveda, Joaquin
7 26,99q
SF
 24
Perey Fica, Javier
8 27,12q
SF
 19
Navarrete Arenas, Tomas
9 27,29
EE
 22
Carriles, Matias
10 27,48
SI
 27
Isla, Alejandro
11 27,61
SI
 21
Molina, Diego
12 27,67
HUMAN
 21
Torres, Giovanni
13 27,99
SEREN
 17
Saez, Matias
14 28,36
SF
 17
Chamorro Jara, Benjamin
15 28,37
MORRO
 17
Riquelme, Duam
16 28,38
ARSU
 17
Pulgar, Javier
17 28,54
ARSU
 17
Lara, Kevin
18 28,57
SI
 18
Carbonell, Tomas
19 28,74
ARAU
 17
Martinez, Eduardo
20 28,78
MAGAL
 17
Tapia, Elian
21 28,97
ARENA
 17
Soto, Nicolas
22 29,01
UNIDO
 21
Olivos, Tomas
23 29,18
EE
 26
Farias, Jose Ignacio
24 29,40
UNIDO
 18
Lara, Joaquin
25 29,51
EE
 35
Peruga, Alberto
26 29,52
AERO
 18
Ortega, Joaquíán
27 30,24
TMF
 19
Ceron, Jean Franco
28 30,94
UNIDO
 17
Gil Buitrago, Antonio
29 31,16
MAKO
 18
Lucares, Alejandro
30 31,29
ATAL
 22
Chavez Hidalgo, Lukas
31 32,09
VICEN
 17
Toledo, Alavro
32 32,21
SEREN
 17
Bustos, Cristobal
33 33,70
WFE
 17
Duarte, Lucas
--- X27,12
MAKO
 17
Estay, Ignacio
--- DQ	
 Evento 4  Mujeres 13-14 50 CL Metro Estilo de Pecho
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 14
Cubillos, Antonia
1 35,81  9
EE
 14
Bennewitz, Catalina
2 36,49  7
MAYOR
 13
Solis, Paulina
3 38,42  6
SSWIM
 13
Moyano, Josefina
4 38,74  5
UNIDO
 13
Reginato, Maria Belen
5 39,55  4
ATAL
 13
Ortiz, Paula
6 39,99  3
ATAL
 13
Asenjo, Renata
7 40,13  2
ARENA
 13
Molina, Natalia
8 40,66  1	
 Evento 4  Mujeres 13-14 50 CL Metro Estilo de Pecho
   Equipo	Nombre Tiempo de Finales
MAYOR
 14
Cubillos, Antonia
1 35,85q
EE
 14
Bennewitz, Catalina
2 36,83q
UNIDO
 13
Reginato, Maria Belen
3 38,94q
SSWIM
 13
Moyano, Josefina
4 38,96q
MAYOR
 13
Solis, Paulina
5 39,41q
ATAL
 13
Ortiz, Paula
6 40,50q
ARENA
 13
Molina, Natalia
*7 41,17q
ATAL
 13
Asenjo, Renata
*7 41,17q
MORRO
 13
Blanco, Valentina
9 41,58
HUMAN
 14
Henriquez, Sofia
10 42,61
MAYOR
 13
Saldes, Paz
11 42,83
MAGAL
 13
Cabello, Giuliana
12 43,21
CDEP
 14
Solano, Sofia
13 43,58
LAUTA
 13
Mora, Alen
14 43,63
ARAU
 13
Gil Rivera, Ana
15 44,28
AUTO
 13
Cordova, Josefina
16 44,63
CDEP
 14
Bustos, Renata Paz
17 44,86
APS
 13
Sepulveda Tapia, Valentina Sofíáa
18 44,97
APS
 14	
Gonzalez Vega, Francisca Antonia
19 45,94
ARSU
 14
Pulgar, Antonia
20 46,07
HUMAN
 13
Gonzalez, Catalina
21 46,40
AMARU
 14
Armijo, Almendra
22 48,13
CDUC
 13
Venegas, Isidora
23 48,59
SEREN
 14
Ampuero, Daniela
24 52,84
 Evento 5  Mujeres 15-16 50 CL Metro Estilo de Pecho
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 15
Matsubara, Key
1 36,18  9
MAYOR
 15
Palomino, Naiomi
2 36,95  7
EE
 16
Marin, Ines
3 37,47  6
CDUC
 15
Pen ña, Beatriz
4 39,12  5
ARENA
 16
Medina, Cosntanza
5 39,74  4
EE
 16
Brito, Carolina
6 43,69  3
MAKO
 16
Acun ña, Sofia
7 44,11  2
SEREN
 15
Sanchez, Valentina
8 46,99  1
 Evento Mujeres 15-16 50 CL Metro Estilo de Pecho
   Equipo	Nombre Tiempo de Finales
MAYOR
 15
Matsubara, Key
1 36,78q
MAYOR
 15
Palomino, Naiomi
2 37,10q
ARENA
 16
Medina, Cosntanza
3 37,37q
EE
 16
Marin, Ines
4 38,35q
SEREN
 15
Sanchez, Valentina
5 39,15q
MAKO
 16
Acun ña, Sofia
6 39,20q
CDUC
 15
Pen ña, Beatriz
7 39,90q

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 3
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
...   (Evento Mujeres 15-16 50 CL Metro Estilo de Pecho)	
Edad	   Equipo	Nombre Tiempo de Finales
EE
 16
Brito, Carolina
8 44,17q	
 Evento 6  Mujeres 17-99 50 CL Metro Estilo de Pecho
   Equipo	Nombre	Tiempo de Finales	
SSWIM
 23
Chanuar, Leila
1 35,11  9
APS
 18
Bru üning Belmar, Maríáa Jose á
2 36,45  7
SEREN
 18
Torres, Pamela
3 36,46  6
UNIDO
 17
Mauriziano, Chiara
4 36,66  5
ATAL
 17
Fuenzalida, Valentina
5 36,68  4
SI
 22
Zecheto, Alessia
6 38,07  3
AUTO
 18
Zepeda, Victoria
7 38,08  2
EE
 19
Vicun ña, Monserrat
8 38,50  1
 Evento 6  Mujeres 17-99 50 CL Metro Estilo de Pecho
   Equipo	Nombre Tiempo de Finales
SSWIM
 23
Chanuar, Leila
1 35,33q
SEREN
 18
Torres, Pamela
2 36,68q
UNIDO
 17
Mauriziano, Chiara
3 36,75q
APS
 18
Bru üning Belmar, Maríáa Jose á
4 37,15q
ATAL
 17
Fuenzalida, Valentina
5 37,44q
AUTO
 18
Zepeda, Victoria
6 37,79q
SI
 22
Zecheto, Alessia
7 38,64q
EE
 19
Vicun ña, Monserrat
8 38,71q
ARSU
 17
Lopez, Rocio
9 39,58
ATAL
 17
Campos Hormazabal, Trinidad
10 40,25
CHIC-ZZ
 17
Fernandez, Constanza
11 42,01
MAYOR
 17
Crisostomo, Maira
12 42,47
 Evento 7  Niños 13-14 800 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
SI
 14
Rau, Constantino
1 8:53,98  9
SI
 14
Montagna, Vicente
2 9:16,67  7
ARENA
 13
Henriquez, Martin
3 9:31,43  6
SSWIM
 14
Rojas, Joaquin
4 9:37,64  5
N ÑIELO
 14
Saavedra, Pablo
5 9:54,85  4
ATAL
 13	
Pe árez Fuenzalida, Alonso Alejandro
6 10:05,84  3
ATAL
 14
Pavez Hormazabal, Cristian
7 10:06,27  2
ARENA
 13
Gomez, David
8 10:08,41  1
SF
 13
Pazmin ño Riffo, Alexander
9 10:13,21
ARSU
 14
Cevo, Enzo
10 10:43,69	
 Evento 7  Hombres 15-16 800 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
UNIDO
 15
De la Vega, Rafael
1 9:21,37  9
SI
 15
Aycauer, Vicente
2 9:28,68  7
MAGAL
 15
Alvarado, Matias
3 9:47,80  6
SF
 16
Moreno Sahlie, Ignacio
4 9:48,43  5
UNIDO
 15
Querales, Marcos
5 9:50,89  4
ATAL
 16
Gonzalez Olivares, Thomas
6 9:59,40  3
UNIDO
 16
Bravo, Benjamin
7 10:06,34  2
VITAC
 15
Pilquiman, Matias
8 10:13,48  1	
 Evento 7  Hombres 17-99 800 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
ATAL
 19
Korzeniowski, Facundo
1 8:53,82  9
UNIDO
 18
Ragazzone, Clemente
2 9:15,35  7
ARSU
 17
Sotelo, Antonio
3 9:34,10  6
SI
 20
Cavada, Ignacio
4 9:47,82  5
TMF
 19
Barros, Sergio
5 9:49,81  4
HUMAN
 20
Molina, Vicente
6 10:02,19  3	
 Evento 8  Mujeres 13-14 400 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
WFE
 14
Klenner, Evaluna
1 4:50,16  9
N ÑIELO
 13
Iturriaga, Soraya
2 4:52,54  7
UNIDO
 14
Custodio, Bruna
3 4:54,91  6
SI
 14
Ramirez, Pia
4 4:55,59  5
SSWIM
 13
Moyano, Josefina
5 5:00,16  4
SSWIM
 13
Castro, Daniela
6 5:01,32  3
MAGAL
 14
Mun ñoz, Skarlet
7 5:03,41  2
MAYOR
 13
Cancino, Paz
8 5:08,84  1
 Evento 8  Mujeres 13-14 400 CL Metro Estilo Libre
   Equipo	Nombre Tiempo de Finales
WFE
 14
Klenner, Evaluna
1 4:55,20q
UNIDO
 14
Custodio, Bruna
2 4:56,36q
SSWIM
 13
Moyano, Josefina
3 4:57,96q
N ÑIELO
 13
Iturriaga, Soraya
4 5:00,27q
SI
 14
Ramirez, Pia
5 5:02,07q
SSWIM
 13
Castro, Daniela
6 5:02,58q
MAGAL
 14
Mun ñoz, Skarlet
7 5:03,97q
MAYOR
 13
Cancino, Paz
8 5:09,30q
CDEP
 13
Anabalon, Sofia
9 5:16,78
WFE
 13
Bratz, Josefa
10 5:19,36
SI
 13
Barrenechea, Alemka
11 5:19,94
SI
 13
Cepeda, Maria Jesus
12 5:20,74
WFE
 14
Llaupe, Janka
13 5:20,82
CDUC
 13
Delgado Noches, Isidora Anto
14 5:21,34
SSWIM
 13
Díáaz, Millaray
15 5:21,83
SF
 13
Jara Gallegos, Sofia
16 5:23,25
TEMUC
 13
Aliste, Josefina
17 5:23,75
VITAC
 13
Miranda, Jennifer
18 5:24,86
MAGAL
 13
Valdes, Isis
19 5:33,58
ATAL
 13
Carrasco, Consuelo
20 5:36,40
CDEP
 13
Abate, Antonia
21 5:47,51
MAGAL
 13
Romero, Francisca
22 5:49,94
MAGAL
 13
Cabello, Giuliana
23 5:51,22
 Evento 9  Mujeres 15-16 400 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 16
Bustamante, Catalina
1 4:40,14  9
VIN ÑA
 15
Contreras, Gabriela
2 4:46,71  7
MAYOR
 16
Lewis, Diana
3 4:49,16  6
VITAC
 15
Kremer, Constanza
4 4:52,84  5
MAYOR
 16
Saldes, Paloma
5 5:02,69  4
SI
 16
Collingwoord, Camila
6 5:06,94  3

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 4
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
Finales ...   (Evento 9  Mujeres 15-16 400 CL Metro Estilo Libre)    Equipo	Nombre	Tiempo de Finales	
OHIGG
 16
Vega Alarcon, Catalina
7 5:08,24  2
UNIDO
 15
Mondaca, Vaithiare
8 5:12,04  1	
 Evento 9  Mujeres 15-16 400 CL Metro Estilo Libre
   Equipo	Nombre Tiempo de Finales
MAYOR
 16
Bustamante, Catalina
1 4:46,34q
VIN ÑA
 15
Contreras, Gabriela
2 4:53,80q
MAYOR
 16
Lewis, Diana
3 4:54,63q
VITAC
 15
Kremer, Constanza
4 4:55,52q
MAYOR
 16
Saldes, Paloma
5 5:05,73q
OHIGG
 16
Vega Alarcon, Catalina
6 5:09,54q
SI
 16
Collingwoord, Camila
7 5:11,62q
UNIDO
 15
Mondaca, Vaithiare
8 5:11,83q
ARAU
 15
Mendez, Martina
9 5:14,95
MAGAL
 16
Gamboa, Kamila
10 5:17,05
SEREN
 15
Carrion, Luna
11 5:19,36
SI
 15
Barrenechea, Krasna
12 5:20,56
VIN ÑA
 15
Mun ñoz, Valentina
13 5:50,31	
 Evento 10  Mujeres 17-99 400 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
SI
 22
Valdivia, Mahina
1 4:36,80  9
N ÑIELO
 17
Delgado, Macarena
2 5:03,00  7
SI
 22
Aguilar, Catalina
3 5:06,96  6
CDEP
 17	
Hernandez Mun ñoz, Constanza
4 5:09,69  5
ATAL
 17
Caceres, Catalina
5 5:18,50  4
VIN ÑA
 17
Pinotti, Amanda
6 5:24,19  3
SI
 20
Diaz, Carla
7 5:32,95  2
VIN ÑA
 17
Gonzalez, Maylin
8 5:42,26  1	
 Evento 10  Mujeres 17-99 400 CL Metro Estilo Libre
   Equipo	Nombre Tiempo de Finales
SI
 22
Valdivia, Mahina
1 4:32,33q
N ÑIELO
 17
Delgado, Macarena
2 4:47,56q
SI
 22
Aguilar, Catalina
3 5:01,04q
CDEP
 17
Hernandez Mun ñoz, Constanza
4 5:02,40q
ATAL
 17
Caceres, Catalina
5 5:09,84q
VIN ÑA
 17
Pinotti, Amanda
6 5:12,15q
VIN ÑA
 17
Gonzalez, Maylin
7 5:16,02q
SI
 20
Diaz, Carla
8 5:16,32q	
 Evento 11  Hombres 13-14 200 CL Metro Estilo de Espalda
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 14
Osorio, Manuel
1 2:13,68  9
CHIC-ZZ
 14
Munoz, Benjamin
2 2:25,04  7
ATAL
 13	
Campos Hormazabal, Benjamin
3 2:26,66  6
SI
 14
Madariaga, Lucas
4 2:28,87  5
EE
 14
Estevez, Simon
5 2:30,87  4
UNIDO
 13
Schnapp, Rafael
6 2:32,32  3
AUTO
 14
Murillo, Rodrigo
7 2:33,69  2
MAKO
 13
Costas, Matias
8 2:37,28  1	
 Evento 11  Hombres 13-14 200 CL Metro Estilo de Espalda
   Equipo	Nombre Tiempo de Finales
MAYOR
 14
Osorio, Manuel
1 2:14,30q
SI
 14
Madariaga, Lucas
2 2:27,26q
ATAL
 13
Campos Hormazabal, Benjamin
3 2:28,32q
CHIC-ZZ
 14
Munoz, Benjamin
4 2:28,85q
UNIDO
 13
Schnapp, Rafael
5 2:32,71q
AUTO
 14
Murillo, Rodrigo
6 2:33,19q
EE
 14
Estevez, Simon
7 2:33,27q
MAKO
 13
Costas, Matias
8 2:36,06q
SEREN
 14
Sepulveda, Vicente
9 2:37,08
N ÑIELO
 14
Saavedra, Pablo
10 2:39,16
CDEP
 13
Moreno Paffetti, Martin
11 2:40,72
ARSU
 13
Caro, Ma áximo
12 2:40,75
ATAL
 13
Sanchez, Sebastian
13 2:43,81
MAYOR
 14
Cortes, Vicente
14 2:47,15
ARENA
 13
Gatica, Leonardo
15 2:49,05
ATAL
 13
Sepu álveda, Cristobal
16 2:49,10
MAGAL
 13
Salazar, Alonso
17 2:49,90
ARAU
 14
Olivares, Gabriel
18 2:50,44
MAKO
 13
Pen ña, Martin
19 2:55,34
MAKO
 13
Carrasco, Martin
20 3:03,52	
 Evento 12  Hombres 15-16 200 CL Metro Estilo de Espalda
   Equipo	Nombre	Tiempo de Finales	
ATAL
 15
Martinez, Diego
1 2:14,90  9
SF
 15
Medina Rios, Samuel
2 2:19,11  7
WFE
 15
Bratz, Octavio
3 2:21,15  6
MAYOR
 15
Urtubia, Jorge
4 2:21,77  5
MAYOR
 15
Reyes, Benjamin
5 2:23,31  4
OHIGG
 16
Negrete, Arturo
6 2:25,54  3
HUMAN
 16
Torres, Maximiliano
7 2:25,65  2
WFE
 15
Lerzundi, Sebastian
--- DQ
 Evento 12  Hombres 15-16 200 CL Metro Estilo de Espalda
   Equipo	Nombre Tiempo de Finales
ATAL
 15
Martinez, Diego
1 2:15,68q
SF
 15
Medina Rios, Samuel
2 2:19,80q
MAYOR
 15
Urtubia, Jorge
3 2:21,80q
WFE
 15
Bratz, Octavio
4 2:23,63q
OHIGG
 16
Negrete, Arturo
5 2:24,46q
MAYOR
 15
Reyes, Benjamin
6 2:24,94q
WFE
 15
Lerzundi, Sebastian
7 2:26,92q
HUMAN
 16
Torres, Maximiliano
8 2:27,03q
CHIC-ZZ
 15
Bobadilla, Patricio
9 2:28,01
CDUC
 15
Dominguez, Enrique
10 2:28,92
WFE
 15
Martinez, Vicente
11 2:29,57
SF
 16
Moreno Sahlie, Ignacio
12 2:29,91
EE
 16
Fernandez, Vicente
13 2:30,26
ARAU
 15
Araya, Pablo
14 2:30,90
APS
 15
Gonzalez Moreno, Diego Rodrigo
15 2:35,01
COQUI
 16
Espinoza, Benjamin
16 2:39,12
ATAL
 15
Barros Palma, Benjamin
17 2:46,01

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 5
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
...   (Evento 12  Hombres 15-16 200 CL Metro Estilo de Espalda)	
Edad	   Equipo	Nombre Tiempo de Finales
MAKO
 15
Dinamarca, Diego
18 2:49,48	
 Evento 13  Hombres 17-99 200 CL Metro Estilo de Espalda
   Equipo	Nombre	Tiempo de Finales	
SI
 20
Ahumada, Maximiliano
1 2:09,10  9
VIN ÑA
 17
Araya, Vicente
2 2:12,22  7
WFE
 17
Duarte, Lucas
3 2:13,59  6
SF
 19
Perdomo Almiro án, Jose á
4 2:15,49  5
UNIDO
 19
Letelier, Tomas P
5 2:20,25  4
SI
 23
Quiroz, Felipe
6 2:24,37  3
MAKO
 17
Toro, Victor
7 2:28,45  2
SI
 24
Borello, Xoan
8 2:32,07  1
 Evento 13  Hombres 17-99 200 CL Metro Estilo de Espalda
   Equipo	Nombre Tiempo de Finales
SI
 20
Ahumada, Maximiliano
1 2:12,03q
VIN ÑA
 17
Araya, Vicente
2 2:13,65q
WFE
 17
Duarte, Lucas
3 2:14,77q
SF
 19
Perdomo Almiro án, Jose á
4 2:15,29q
UNIDO
 19
Letelier, Tomas P
5 2:21,35q
SI
 23
Quiroz, Felipe
6 2:23,34q
MAKO
 17
Toro, Victor
7 2:27,35q
SI
 24
Borello, Xoan
8 2:27,73q
UNIDO
 18
Bustamante, Hugo
9 2:27,91
CDEP
 17
Zagal, Jalil
10 2:33,86
AMARU
 17
Antiguay, Matias
11 2:35,19
VITAC
 19
Bertranou, Matias
12 2:52,66
MAKO
 22
Olea, David
13 2:55,70	
 Evento 14  Mujeres 13-14 100 CL Metro Estilo de Mariposa
   Equipo	Nombre	Tiempo de Finales	
SI
 14
Reyes, Fernanda
1 1:06,86  9
MAYOR
 14
Ardiles, Trinidad
2 1:06,99  7
ATAL
 13	
Concha Marquez, Florencia Paz
3 1:08,65  6
HUMAN
 14
Orellana, Sofia
4 1:10,95  5
CDUC
 14
Pacheco, Matilda
5 1:11,11  4
CDEP
 13
Mun ñoz Barrios, Emilia
6 1:11,31  3
UNIDO
 13
Figueroa, Amanda
7 1:12,80  2
MAGAL
 14
Andersen, Sophia
8 1:14,22  1	
 Evento 14  Mujeres 13-14 100 CL Metro Estilo de Mariposa
   Equipo	Nombre Tiempo de Finales
MAYOR
 14
Ardiles, Trinidad
1 1:07,83q
ATAL
 13
Concha Marquez, Florencia Paz
2 1:08,16q
SI
 14
Reyes, Fernanda
3 1:08,42q
HUMAN
 14
Orellana, Sofia
4 1:10,53q
CDUC
 14
Pacheco, Matilda
5 1:11,26q
UNIDO
 13
Figueroa, Amanda
6 1:12,88q
CDEP
 13
Mun ñoz Barrios, Emilia
7 1:13,21q
MAGAL
 14
Andersen, Sophia
8 1:14,08q
SSWIM
 14
Gonza ález, Fernanda
9 1:14,13 ARENA
 13
Ampuero, Martina
10 1:15,04
MAGAL
 14
Ortega, Constanza
11 1:15,55
MAKO
 13
Yan ñez, Catalina
12 1:16,01
SI
 14
Ramirez, Pia
13 1:16,33
ATAL
 14
Castro Gonzalez, Antonia
14 1:16,57
MAGAL
 13
Valdes, Isis
15 1:19,90
MAYOR
 13
Gonzales, Magdalena
16 1:20,08
VIN ÑA
 14
Lara, Valeria
17 1:23,51
UNIDO
 14
Gonzalez, Victoria
18 1:24,12
N ÑIELO
 13
Carrasco, Laura
19 1:25,08
AERO
 14
Corte ás, Paz
20 1:27,63
AV
 13
Medina, Josefa
21 1:27,70
VICEN
 14
Ahumada, Fernanda
22 1:28,20
MAKO
 13
Cruz, Isidora
23 1:29,11
PEN ÑAL
 13
Santana, Rocio
24 1:29,51	
 Evento 15  Mujeres 15-16 100 CL Metro Estilo de Mariposa
   Equipo	Nombre	Tiempo de Finales	
EE
 16
Marin, Ines
1 1:03,98  9
MAYOR
 16
Lewis, Diana
2 1:09,47  7
SI
 16
Zamora, Alicia
3 1:10,80  6
VIN ÑA
 15
Vallana, Javiera
4 1:11,53  5
ATAL
 15
Robles, Roberta
5 1:11,95  4
MAYOR
 15
Palomino, Naiomi
6 1:14,27  3
WFE
 15
Martorel, Micaela
7 1:14,96  2
CDEP
 15
Smith, Catalina
8 1:15,09  1
 Evento 15  Mujeres 15-16 100 CL Metro Estilo de Mariposa
   Equipo	Nombre Tiempo de Finales
EE
 16
Marin, Ines
1 1:04,84q
MAYOR
 16
Lewis, Diana
2 1:10,94q
SI
 16
Zamora, Alicia
3 1:11,89q
VIN ÑA
 15
Vallana, Javiera
4 1:11,93q
ATAL
 15
Robles, Roberta
5 1:12,66q
WFE
 15
Martorel, Micaela
6 1:13,29q
MAYOR
 15
Palomino, Naiomi
7 1:13,41q
CDEP
 15
Smith, Catalina
8 1:15,02q
VITAC
 15
Kremer, Constanza
9 1:15,33
MORRO
 15
Ojeda, Damari
10 1:18,53
ARENA
 15
Gajardo, Martina
11 1:19,25
CDUC
 15
Stein, Valentina
12 1:27,86	
 Evento 16  Mujeres 17-99 100 CL Metro Estilo de Mariposa
   Equipo	Nombre	Tiempo de Finales	
SI
 27
Perez, Paola
1 1:05,59  9
ATAL
 20
Gutierrez, Savka
2 1:10,27  7
EE
 17
Carren ño, Angela
3 1:10,57  6
ATAL
 17
Caceres, Catalina
4 1:10,77  5
MAKO
 24
Olivares, Carolina
5 1:11,96  4
ATAL
 17
Rebolledo, M. Fernanda
6 1:13,09  3
MAKO
 22
Jimenez, Margaret
7 1:13,25  2
CDUC
 25
Chamorro, Alejandra
8 1:13,47  1
VITAC
 19
Videla, Valeria
9 1:15,57
CDEP
 17
Cardona, Valeria
10 1:16,31

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 6
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
 Evento 16  Mujeres 17-99 100 CL Metro Estilo de Mariposa    Equipo	Nombre Tiempo de Finales
SI
 27
Perez, Paola
1 1:05,57q
ATAL
 20
Gutierrez, Savka
2 1:08,07q
ATAL
 17
Rebolledo, M. Fernanda
3 1:08,59q
EE
 17
Carren ño, Angela
4 1:09,10q
CDUC
 25
Chamorro, Alejandra
5 1:09,40q
CDEP
 17
Cardona, Valeria
6 1:10,03q
MAKO
 24
Olivares, Carolina
7 1:11,00q
MAKO
 22
Jimenez, Margaret
8 1:11,12q
VITAC
 19
Videla, Valeria
9 1:12,37q
ATAL
 17
Caceres, Catalina
10 1:13,05q	
 Evento 17  Hombres 13-14 100 CL Metro Estilo de Pecho
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 14
Lazzerini, Mariano
1 1:08,66  9
HUMAN
 13
Cereceda, Maximiliano
2 1:09,04  7
WFE
 14
Crhistopher, Conus
3 1:15,82  6
TEMUC
 14
Gesche, Diego
4 1:17,00  5
ATAL
 14
Parada, Benjamin
5 1:17,68  4
ARENA
 14
Cubillos, Vicente
6 1:17,78  3
EE
 13
Salazar, Andoni
7 1:18,43  2
UNIDO
 14
Lim, Sean
8 1:19,94  1
 Evento 17  Hombres 13-14 100 CL Metro Estilo de Pecho
   Equipo	Nombre Tiempo de Finales
MAYOR
 14
Lazzerini, Mariano
1 1:08,26q
HUMAN
 13
Cereceda, Maximiliano
2 1:10,70q
WFE
 14
Crhistopher, Conus
3 1:15,93q
ARENA
 14
Cubillos, Vicente
4 1:17,93q
ATAL
 14
Parada, Benjamin
5 1:18,28q
TEMUC
 14
Gesche, Diego
6 1:18,48q
EE
 13
Salazar, Andoni
7 1:18,54q
UNIDO
 14
Lim, Sean
8 1:19,34q
ARSU
 13
Gajardo, Juan Pablo
9 1:19,61
SI
 13
Marin, Santiago
10 1:19,76
AUTO
 13
Gonzalez, Benjamin
11 1:20,66
EE
 14
Bravo, Max
12 1:21,48
MAKO
 13
Barra, Benjamin
13 1:21,69
SSWIM
 14
Ramos, Santiago
14 1:21,81
MAGAL
 14
Berrios, Reinaldo
15 1:21,91
APS
 13
Melin Del Valle, Reiner Alario
16 1:22,07
SI
 14
Oteiza, Antonio
17 1:22,60
ARENA
 14
Castillo, Nicolas
18 1:23,26
MAKO
 14
Gallardo, Sebastian
19 1:23,93
CDEP
 14
Acevedo  Celedon, Matias
20 1:24,10
CDEP
 14
Valderrama, Lucas
21 1:24,11
MAYOR
 13
Barriga, Sebastian
22 1:25,36
SF
 14
Mora Orellana, Gonzalo
23 1:25,96
AUTO
 14
Galleguillos, Lorenzo
24 1:26,07
CDUC
 14
Dufflocq, Julio
25 1:26,61
CDEP
 13
Moreno Paffetti, Martin
26 1:26,81
MAKO
 13
Manordes, Lucas
27 1:27,48 SI
 13
Rodriguez, Agustin
28 1:28,11
SI
 13
Gergi, Christian
29 1:30,69
HUMAN
 13
Molins, Vicente
30 1:31,26
SEREN
 13
Torres, Ismael
31 1:36,59
ARENA
 13
Martinez, Tomas
32 1:37,09
UNIDO
 14
Yan ñez, Francisco
--- DQ	
 Evento 18  Hombres 15-16 100 CL Metro Estilo de Pecho
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 16
Olivos, Joaquin
1 1:11,14  9
ATAL
 15
Martinez, Diego
2 1:14,01  7
MAYOR
 15
Aranguiz, Lucas
3 1:15,87  6
SEREN
 15
Bernal, Pacual
4 1:16,06  5
SI
 15
De Ferrari, Constantino
5 1:17,57  4
VIN ÑA
 16
Almonacid, Vicente
6 1:17,74  3
ARENA
 15
Gutierrez, Nicolas
7 1:19,72  2
AV
 16	
Hansen Tatter, Gerhart Nicholas	--- DQ	
 Evento 18  Hombres 15-16 100 CL Metro Estilo de Pecho
   Equipo	Nombre Tiempo de Finales
AV
 16
Hansen Tatter, Gerhart Nicholas
1 1:09,96q
MAYOR
 16
Olivos, Joaquin
2 1:10,65q
ATAL
 15
Martinez, Diego
3 1:11,41q
MAYOR
 15
Aranguiz, Lucas
4 1:16,27q
SI
 15
De Ferrari, Constantino
5 1:16,55q
SEREN
 15
Bernal, Pacual
6 1:16,92q
VIN ÑA
 16
Almonacid, Vicente
7 1:17,96q
ARENA
 15
Gutierrez, Nicolas
8 1:19,28q
MAKO
 15
Dinamarca, Matias
9 1:19,90
SEREN
 15
Navia, Matias
10 1:20,01
WFE
 15
Conus, Sergio
11 1:20,24
CDUC
 16
Ca áceres, Joaquin
12 1:21,92
AUTO
 15
Zepeda, Agustin
13 1:22,22
HUMAN
 16
Camus, Patricio
14 1:22,47
SSWIM
 15
Castan ñon, Diego
15 1:22,94
MAKO
 16
Flores, Gabriel
16 1:24,08
AMARU
 15
Meza, Matias
17 1:25,66
VICEN
 15
Gonzalez, Jorge
18 1:29,38
SEREN
 16
Bustos, Felipe
19 1:38,14	
 Evento 19  Hombres 17-99 100 CL Metro Estilo de Pecho
   Equipo	Nombre	Tiempo de Finales	
MAKO
 26
Promo, Renato
1 1:01,67  9
EE
 17
Ortego, Ignacio
2 1:07,92  7
MAYOR
 17
Alvarez, Ignacio
3 1:08,26  6
ATAL
 20
Furtado, Agustin
4 1:08,68  5
EE
 19
Quintero, Felipe
5 1:10,05  4
UNIDO
 17
Gil Buitrago, Antonio
6 1:10,97  3
SF
 18
Pin ñerua Cuevas, Carlos
7 1:12,08  2
CDUC
 19
De Andraca, Roberto
8 1:13,87  1
 Evento 19  Hombres 17-99 100 CL Metro Estilo de Pecho
   Equipo	Nombre Tiempo de Finales
MAKO
 26
Promo, Renato
1 1:07,12q

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 7
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
...   (Evento 19  Hombres 17-99 100 CL Metro Estilo de Pecho)	
Edad	   Equipo	Nombre Tiempo de Finales
MAYOR
 17
Alvarez, Ignacio
2 1:08,08q
EE
 17
Ortego, Ignacio
3 1:08,63q
ATAL
 20
Furtado, Agustin
4 1:10,02q
EE
 19
Quintero, Felipe
5 1:10,04q
UNIDO
 17
Gil Buitrago, Antonio
6 1:10,92q
SF
 18
Pin ñerua Cuevas, Carlos
7 1:12,09q
CDUC
 19
De Andraca, Roberto
8 1:13,59q
MAYOR
 23
Sepulveda, Joaquin
9 1:14,83
HUMAN
 21
Reyes, Claudio
10 1:15,73
ARAU
 17
Martinez, Eduardo
11 1:16,21
UNIDO
 21
Olivos, Tomas
12 1:16,90
ARSU
 22
Diaz, Andres
13 1:17,05
UNIDO
 17
Jara, Felipe
14 1:18,08
ATAL
 20
Escobar, Vicente
15 1:18,63
ARSU
 18
Gallardo, Joaquin
16 1:18,97
EE
 35
Peruga, Alberto
17 1:20,18
TMF
 20
Acevedo, Juan Pablo
18 1:22,25
SEREN
 17
Bustos, Cristobal
19 1:28,44
ADESE
 17
De la Barra, Benjamin
20 1:29,69	
 Evento 20  Mujeres 13-14 200 CL Metro CI
   Equipo	Nombre	Tiempo de Finales	
SI
 14
Reyes, Fernanda
1 2:28,51  9
MAYOR
 14
Cubillos, Antonia
2 2:31,33  7
WFE
 14
Klenner, Evaluna
3 2:41,38  6
MAGAL
 14
Andersen, Sophia
4 2:45,37  5
ARENA
 13
Molina, Natalia
5 2:45,80  4
UNIDO
 13
Reginato, Maria Belen
6 2:46,50  3
MAYOR
 13
Solis, Paulina
7 2:46,63  2
SI
 13
Barrenechea, Alemka
8 2:50,61  1
 Evento 20  Mujeres 13-14 200 CL Metro CI
   Equipo	Nombre Tiempo de Finales
SI
 14
Reyes, Fernanda
1 2:33,88q
MAYOR
 14
Cubillos, Antonia
2 2:33,94q
WFE
 14
Klenner, Evaluna
3 2:40,65q
MAGAL
 14
Andersen, Sophia
4 2:46,15q
MAYOR
 13
Solis, Paulina
5 2:47,13q
ARENA
 13
Molina, Natalia
6 2:48,10q
SI
 13
Barrenechea, Alemka
7 2:49,40q
UNIDO
 13
Reginato, Maria Belen
8 2:50,33q
WFE
 13
Bratz, Josefa
9 2:50,48
VITAC
 13
Alberti, Giuliana
*10 2:50,80
MAGAL
 14
Ortega, Constanza
*10 2:50,80
EE
 14
Bennewitz, Catalina
12 2:51,11
HUMAN
 14
Henriquez, Sofia
13 2:53,25
ATAL
 13
Asenjo, Renata
14 2:55,13
APS
 14
Buzolic Moreno, Tonka Alejandra
15 2:55,61
ATAL
 13
Ortiz, Paula
16 2:56,03
AERO
 14
Rojas, Catalina
17 2:56,40
MAKO
 13
Yan ñez, Catalina
18 2:56,84
MORRO
 13
Blanco, Valentina
19 2:57,74
LAUTA
 13
Mora, Alen
20 2:59,66
ARENA
 14
Perez, Francisca
21 3:00,03
ATAL
 13
Carrasco, Consuelo
22 3:00,31
CDEP
 14
Bustos, Renata Paz
23 3:01,06
ARAU
 13
Gil Rivera, Ana
24 3:01,19
UNIDO
 14
Gonzalez, Victoria
25 3:07,66
APS
 13	
Sepulveda Tapia, Valentina Sofíáa
26 3:09,75
PEN ÑAL
 13
Santana, Rocio
27 3:10,33
APS
 14	
Gonzalez Vega, Francisca Antonia
28 3:11,19
MAKO
 13
Cruz, Isidora
29 3:13,03
VITAC
 13
Miranda, Jennifer
30 3:13,53
SI
 13
Lagos, Rocio
31 3:16,29
MAKO
 13
Ortubia, Gabriela
32 3:33,15
 Evento 21  Mujeres 15-16 200 CL Metro CI
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 15
Matsubara, Key
1 2:33,34  9
MAYOR
 16
Bustamante, Catalina
2 2:36,15  7
VIN ÑA
 15
Vallana, Javiera
3 2:38,52  6
OHIGG
 16
Vega Alarcon, Catalina
4 2:39,85  5
SI
 16
Collingwoord, Camila
5 2:44,37  4
ATAL
 15
Robles, Roberta
6 2:48,17  3
ARENA
 16
Medina, Cosntanza
7 2:50,59  2
UNIDO
 15
Mondaca, Vaithiare
8 2:51,92  1
 Evento 21  Mujeres 15-16 200 CL Metro CI
   Equipo	Nombre Tiempo de Finales
MAYOR
 15
Matsubara, Key
1 2:38,58q
MAYOR
 16
Bustamante, Catalina
2 2:40,06q
VIN ÑA
 15
Vallana, Javiera
3 2:41,35q
OHIGG
 16
Vega Alarcon, Catalina
4 2:42,99q
SI
 16
Collingwoord, Camila
5 2:45,67q
ATAL
 15
Robles, Roberta
6 2:46,63q
UNIDO
 15
Mondaca, Vaithiare
7 2:50,60q
ARENA
 16
Medina, Cosntanza
8 2:52,47q
SI
 15
Barrenechea, Krasna
9 2:53,02
CDEP
 15
Balderas, Tania
10 2:55,33
AV
 15
Medina Solis, Jazmin
11 2:56,02
CDEP
 15
Smith, Catalina
12 2:57,28
CDEP
 15
Llunell Vilte, Janett
13 2:59,46
MAKO
 16
Acun ña, Sofia
14 3:07,89
COQUI
 16
Rojas, Carolina
15 3:08,89
TMF
 15
Garrido, Cecilia
16 3:13,27
SEREN
 15
Sanchez, Valentina
17 3:27,17	
 Evento 22  Mujeres 17-99 200 CL Metro CI
   Equipo	Nombre	Tiempo de Finales	
SI
 27
Perez, Paola
1 2:31,93  9
OHIGG
 19	
Pen ñailillo Alfonso, Anita Cristina
2 2:38,94  7
CDUC
 17
Bobadilla, Catalina
3 2:39,67  6
SI
 22
Valdivia, Mahina
4 2:41,00  5
EE
 19
Vicun ña, Monserrat
5 2:50,07  4
CDUC
 25
Chamorro, Alejandra
6 2:52,80  3
ATAL
 17
Rebolledo, M. Fernanda
7 3:05,85  2

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 8
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
Finales ...   (Evento 22  Mujeres 17-99 200 CL Metro CI)    Equipo	Nombre	Tiempo de Finales	
AUTO
 18
Zepeda, Victoria
--- DQ	
 Evento 22  Mujeres 17-99 200 CL Metro CI
   Equipo	Nombre Tiempo de Finales
SI
 27
Perez, Paola
1 2:38,69q
CDUC
 17
Bobadilla, Catalina
2 2:42,25q
OHIGG
 19
Pen ñailillo Alfonso, Anita Cristina
3 2:42,92q
SI
 22
Valdivia, Mahina
4 2:44,43q
AUTO
 18
Zepeda, Victoria
5 2:45,98q
EE
 19
Vicun ña, Monserrat
6 2:48,88q
CDUC
 25
Chamorro, Alejandra
7 2:49,31q
ATAL
 17
Rebolledo, M. Fernanda
8 2:51,28q
CDEP
 17
Cardona, Valeria
9 2:55,49
CHIC-ZZ
 17
Fernandez, Constanza
10 2:59,69
CDUC
 26
Vacher, Francisca
11 3:10,72
UNIDO
 24
Ramirez, Carolina
12 3:33,05	
 Evento 23  Hombres 13-14 200 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
SF
 13
Cisternas Gomez, Eduardo
1 2:00,41  9
MAYOR
 14
Osorio, Manuel
2 2:01,51  7
SF
 14
Marchesini Ayala, Alejandro
3 2:02,08  6
SI
 14
Madariaga, Lucas
4 2:02,45  5
SI
 14
Rau, Constantino
5 2:04,86  4
SI
 13
Marin, Santiago
6 2:05,82  3
SI
 14
Montagna, Vicente
7 2:09,72  2
ATAL
 13	
Campos Hormazabal, Trinidad
8 2:11,64  1	
 Evento 23  Hombres 13-14 200 CL Metro Estilo Libre
   Equipo	Nombre Tiempo de Finales
SI
 14
Rau, Constantino
1 2:04,78q
SI
 14
Madariaga, Lucas
2 2:04,81q
SF
 13
Cisternas Gomez, Eduardo
3 2:04,96q
SI
 13
Marin, Santiago
4 2:06,16q
SI
 14
Montagna, Vicente
5 2:06,96q
MAYOR
 14
Osorio, Manuel
6 2:08,51q
SF
 14
Marchesini Ayala, Alejandro
7 2:08,87q
ATAL
 13
Campos Hormazabal, Benjamin
8 2:10,56q
MAYOR
 14
Menendez, Jose
9 2:10,59
SSWIM
 14
Rojas, Joaquin
10 2:12,03
UNIDO
 14
Gustin, Daniel
11 2:12,64
ARENA
 14
Biscupovic, Nicolas
12 2:13,80
MAGAL
 14
Jara, Cristobal
13 2:16,03
SSWIM
 14
Pavez, Martíán
14 2:16,79
ARENA
 13
Henriquez, Martin
15 2:17,54
ARENA
 14
Castillo, Nicolas
16 2:17,96
WFE
 14
Franco, Guillermo
17 2:19,47
CHIC-ZZ
 14
Munoz, Benjamin
18 2:19,49
SSWIM
 14
Annaratone, Daniel
19 2:20,71
AUTO
 13
Gonzalez, Benjamin
20 2:21,23
MAKO
 14
Andalaft, Ignacio
21 2:21,41
MAKO
 14
Fernandez, Alonso
22 2:21,53 CDEP
 14
Acevedo  Celedon, Matias
23 2:22,92
MAGAL
 13
Green, Vicente
24 2:23,34
SF
 13
Pazmin ño Riffo, Alexander
25 2:23,72
SF
 13
Alonso Vasquez, Pablo
26 2:23,78
SF
 14
Tapia Aguilera, Pedro
27 2:24,78
HUMAN
 14
Henriquez, Cristian
28 2:25,00
ARSU
 14
Cevo, Enzo
29 2:25,14
ATAL
 14
Manriquez, Joaquin
30 2:25,36
ADESE
 14
Villanueva, Enrique
31 2:25,53
ATAL
 14
Esteves, Emilio
32 2:27,05
EE
 14
Wensioe, Martin
33 2:27,50
TEMUC
 14
Saavedra, Pablo
34 2:27,95
MAKO
 13
Manordes, Lucas
35 2:28,18
VITAC
 13
Pilquiman, Nicolas
36 2:28,76
ARENA
 13
Gatica, Leonardo
37 2:28,84
MAKO
 13
Barraza, Bruno
38 2:29,64
TEMUC
 13
Moreno, Jose Pablo
39 2:30,35
EE
 14
Bravo, Max
40 2:31,16
MAYOR
 14
Cortes, Vicente
41 2:31,37
TMF
 13
Suarez, Pablo
42 2:31,60
AUTO
 14
Galleguillos, Lorenzo
43 2:31,77
SEREN
 13
Vega, Cristobal
44 2:36,61
CDUC
 14
Dufflocq, Julio
45 2:42,58
SEREN
 13
Saez, Alex
46 2:45,13
SEREN
 13
Torres, Ismael
47 2:54,05	
 Evento 24  Hombres 15-16 200 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
UNIDO
 16
Schnapp, Benjamin
1 1:59,89  9
MAGAL
 16
Cespedes, Diego
2 2:02,10  7
CDUC
 15
Bobadilla, Nicolas
3 2:02,77  6
MAYOR
 16
Olivos, Lucas
4 2:04,21  5
ATAL
 16
Mena, Santiago
5 2:06,00  4
SF
 16
Ortiz Mun ñoz, Vicente
6 2:07,00  3
CHIC-ZZ
 15
Bobadilla, Patricio
7 2:07,24  2
WFE
 15
Lerzundi, Sebastian
8 2:10,02  1
 Evento 24  Hombres 15-16 200 CL Metro Estilo Libre
   Equipo	Nombre Tiempo de Finales
UNIDO
 16
Schnapp, Benjamin
1 2:02,47q
MAGAL
 16
Cespedes, Diego
2 2:04,78q
CDUC
 15
Bobadilla, Nicolas
3 2:04,80q
MAYOR
 16
Olivos, Lucas
4 2:05,21q
ATAL
 16
Mena, Santiago
5 2:05,91q
SF
 16
Ortiz Mun ñoz, Vicente
6 2:07,73q
WFE
 15
Lerzundi, Sebastian
7 2:08,94q
CHIC-ZZ
 15
Bobadilla, Patricio
8 2:10,38q
SI
 15
De la Rivera, Ignacio
9 2:11,12
SSWIM
 15
Baeza, Nicola ás
10 2:11,23
UNIDO
 16
Bravo, Benjamin
11 2:12,27
UNIDO
 15
De la Vega, Rafael
12 2:12,41
AV
 15
Salgado, Martin
13 2:13,80
UNIDO
 15
Querales, Marcos
14 2:14,11
VITAC
 15
Pilquiman, Matias
15 2:14,30
MAGAL
 15
Alvarado, Matias
16 2:14,44

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 9
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
...   (Evento 24  Hombres 15-16 200 CL Metro Estilo Libre)	
Edad	   Equipo	Nombre Tiempo de Finales
MAYOR
 15
Reyes, Benjamin
17 2:15,79
EE
 16
Fernandez, Vicente
18 2:16,10
MAKO
 16
Aravena, Martin
19 2:17,34
APS
 15
Gonzalez Moreno, Diego Rodrigo
20 2:17,52
ARAU
 15
Carvajal, Luciano
21 2:17,61
ATAL
 16
Gonzalez Olivares, Thomas
22 2:18,14
WFE
 15
Orizola, Sebastian
23 2:21,06
CDUC
 16
Luttges, Arturo
24 2:21,16
MAKO
 15
Dinamarca, Matias
25 2:22,13
APS
 16	
Castellanos Villela, Cristian Daniel
26 2:23,21
HUMAN
 15
Agurto, Lucas
27 2:23,82
ARSU
 16
Pfiffer, Martíán
28 2:25,86
AUTO
 16
Barrera, Juan
29 2:27,07
AMARU
 15
Meza, Matias
30 2:28,99
MAKO
 15
Dinamarca, Diego
31 2:30,19
CDUC
 16
Romero, Diego
32 2:30,50
MAGAL
 15
Valenzuela, Joaquin
33 2:32,24
AMARU
 16
Meza, Pablo
34 2:32,66
 Evento 25  Hombres 17-99 200 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 18
Araya, Gabriel
1 1:57,45  9
SF
 19
Perdomo Almiro án, Jose á
2 1:58,21  7
UNIDO
 18
Ragazzone, Clemente
3 2:02,91  6
ATAL
 19
Korzeniowski, Facundo
4 2:04,71  5
ARENA
 17
Soto, Nicolas
5 2:06,57  4
MAGAL
 17
Tapia, Elian
6 2:07,53  3
UNIDO
 19
Letelier, Tomas P
7 2:07,82  2
EE
 25
Labra, Felipe
8 2:11,54  1
 Evento 25  Hombres 17-99 200 CL Metro Estilo Libre
   Equipo	Nombre Tiempo de Finales
SF
 19
Perdomo Almiro án, Jose á
1 1:59,61q
MAYOR
 18
Araya, Gabriel
2 2:02,15q
UNIDO
 18
Ragazzone, Clemente
3 2:02,20q
ATAL
 19
Korzeniowski, Facundo
4 2:02,67q
ARENA
 17
Soto, Nicolas
5 2:06,78q
UNIDO
 19
Letelier, Tomas P
6 2:07,39q
MAGAL
 17
Tapia, Elian
7 2:07,50q
EE
 25
Labra, Felipe
8 2:08,27q
SI
 23
Salazar, Felipe
9 2:09,88
SF
 24
Perey Fica, Javier
10 2:09,95
ARSU
 17
Sotelo, Antonio
11 2:10,25
HUMAN
 18
Fuentes, Marcelo
12 2:12,97
CDEP
 17
Zagal, Jalil
13 2:13,25
SI
 20
Cavada, Ignacio
14 2:14,28
HUMAN
 17
Retamal, Martin
15 2:15,15
EE
 22
Carriles, Matias
16 2:15,69
SI
 23
Marchetti, Martin
17 2:15,79
SI
 20
Ahumada, Maximiliano
18 2:17,09
HUMAN
 18
Reyes, Cristobal
19 2:18,65
EE
 26
Farias, Jose Ignacio
20 2:24,84
MAKO
 22
Olea, David
21 2:30,03 AERO
 18
Ortega, Joaquíán
22 2:32,52	
 Evento 26  Mujeres 15-16 800 CL Metro Estilo Libre Relevo
 	
Relevo	Equipo	Tiempo de Finales	
Finales A
MAYOR
1 9:23,45  18
1) Bustamante, Catalina 16 2) Saldes, Paloma 16
3) Matsubara, Key 15 4) Lewis, Diana 16
A
SI
2 10:11,72  14
1) Collingwoord, Camila 16 2) Zamora, Alicia 16
3) Barrenechea, Krasna 15 4) Gomez, Renata 15
A
CDEP
3 10:33,73  12
 Evento 26  Mujeres 15-16 800 CL Metro Estilo Libre Relevo
 	
Relevo	Equipo Tiempo de Finales
A
MAYOR
1 8:38,10q
1) Bustamante, Catalina 16 2) Saldes, Paloma 16
3) Matsubara, Key 15 4) Lewis, Diana 16
A
CDEP
2 9:45,02q
1) Llunell Vilte, Janett 15 2) Balderas, Tania 15
3) Smith, Catalina 15 4) Zavala, Aranzazu 15
A
SI
3 9:50,04q
1) Collingwoord, Camila 16 2) Zamora, Alicia 16
3) Barrenechea, Krasna 15 4) Gomez, Renata 15	
 Evento 26  Mujeres 17-99 800 CL Metro Estilo Libre Relevo
 	
Relevo	Equipo	Tiempo de Finales	
Finales A
SI
1 9:34,45  18
1) Valdivia, Mahina 22 2) Perez, Paola 27
3) Aguilar, Catalina 22 4) Diaz, Carla 20
A
ATAL
2 9:49,83  14
1) Caceres, Catalina 17	
2) Campos Hormazabal, Trinidad 17	
3) Rebolledo, M. Fernanda 17 4) Fuenzalida, Valentina 17
A
MAKO
3 9:57,75  12
1) Thoma, Kathi 22 2) Ramirez, Maria Victoria 19
3) Olivares, Carolina 24 4) Jimenez, Margaret 22	
 Evento 26  Mujeres 17-99 800 CL Metro Estilo Libre Relevo
 	
Relevo	Equipo Tiempo de Finales
A
MAKO
1 9:45,00q
1) Thoma, Kathi 22 2) Ramirez, Maria Victoria 19
3) Olivares, Carolina 24 4) Jimenez, Margaret 22
A
SI
2 9:45,03q
1) Valdivia, Mahina 22 2) Perez, Paola 27
3) Aguilar, Catalina 22 4) Diaz, Carla 20
A
ATAL
3 9:50,03q
1) Caceres, Catalina 17	
2) Campos Hormazabal, Trinidad 17	
3) Rebolledo, M. Fernanda 17 4) Fuenzalida, Valentina 17	
 Evento 27  Mujeres 13-14 50 CL Metro Estilo de Mariposa
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 14
Ardiles, Trinidad
1 30,60  9
WFE
 14
Klenner, Evaluna
2 30,99  7
ATAL
 13	
Concha Marquez, Florencia Paz
3 31,05  6
WFE
 13
Bratz, Josefa
4 31,81  5
PEN ÑAL
 14
Hafon, Gabriela
5 31,91  4

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 10
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
Finales ...   (Evento 27  Mujeres 13-14 50 CL Metro Estilo de Mariposa)    Equipo	Nombre	Tiempo de Finales	
ARENA
 13
Ampuero, Martina
6 32,22  3
SSWIM
 13
Díáaz, Millaray
7 32,63  2
MAGAL
 14
Andersen, Sophia
8 33,17  1	
 Evento 27  Mujeres 13-14 50 CL Metro Estilo de Mariposa
   Equipo	Nombre Tiempo de Finales
MAYOR
 14
Ardiles, Trinidad
1 30,27q
ATAL
 13
Concha Marquez, Florencia Paz
2 31,63q
WFE
 14
Klenner, Evaluna
3 32,12q
WFE
 13
Bratz, Josefa
4 32,18q
PEN ÑAL
 14
Hafon, Gabriela
5 32,52q
SSWIM
 13
Díáaz, Millaray
6 32,59q
ARENA
 13
Ampuero, Martina
7 32,63q
MAGAL
 14
Andersen, Sophia
8 33,30q
CDUC
 14
Pacheco, Matilda
9 33,35
AERO
 14
Corte ás, Paz
10 33,45
SEREN
 13
Diaz, Antonia
11 33,50
ATAL
 14
Castro Gonzalez, Antonia
12 33,62
CDEP
 13
Mun ñoz Barrios, Emilia
13 33,68
MAKO
 13
Yan ñez, Catalina
14 33,89
UNIDO
 13
Figueroa, Amanda
15 33,97
MAGAL
 14
Mun ñoz, Skarlet
16 34,10
VICEN
 14
Ahumada, Fernanda
17 34,33
AV
 13
Medina, Josefa
18 34,35
MAYOR
 13
Gonzales, Magdalena
19 34,90
MAGAL
 14
Ortega, Constanza
20 34,97
N ÑIELO
 13
Iturriaga, Soraya
21 35,25
PEN ÑAL
 13
Santana, Rocio
22 35,54
UNIDO
 14
Gonzalez, Victoria
23 35,62
VIN ÑA
 14
Lara, Valeria
24 35,98
VICEN
 14
Quinteros, Elizabeth
25 36,08
VICEN
 14
Gonzalez, Isidora
26 36,09
MAKO
 13
Cruz, Isidora
27 36,12
ATAL
 14
Moya Henriquez, Antonia
28 36,78
ARAU
 13
Gil Rivera, Ana
29 36,95
CDUC
 13
Venegas, Isidora
30 37,25
CDUC
 13	
Delgado Noches, Isidora Antonia
31 39,46
HUMAN
 13
Diaz, Catalina
32 40,00
APS
 13	
Ortiz Herna ández, Barbara Aracely
33 40,29
 Evento 28  Mujeres 15-16 50 CL Metro Estilo de Mariposa
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 16
Lewis, Diana
1 30,78  9
MAYOR
 15
Palomino, Naiomi
2 31,17  7
SI
 16
Zamora, Alicia
3 31,64  6
WFE
 15
Martorel, Micaela
4 32,01  5
VIN ÑA
 15
Vallana, Javiera
5 32,44  4
ARENA
 15
Gajardo, Martina
6 32,68  3
COQUI
 16
Rojas, Carolina
7 33,67  2
EE
 15
Quiroga, Renata
8 33,74  1	
 Evento 28  Mujeres 15-16 50 CL Metro Estilo de Mariposa
   Equipo	Nombre Tiempo de Finales
MAYOR
 16
Lewis, Diana
1 31,36q
MAYOR
 15
Palomino, Naiomi
*2 31,74q
SI
 16
Zamora, Alicia
*2 31,74q
VIN ÑA
 15
Vallana, Javiera
4 32,74q
WFE
 15
Martorel, Micaela
5 33,05q
EE
 15
Quiroga, Renata
6 33,22q
ARENA
 15
Gajardo, Martina
7 33,45q
COQUI
 16
Rojas, Carolina
8 33,52q
ATAL
 16
Zamora Torres, Laura
9 33,57
ARSU
 16
Seyssel, Pamela
10 34,04
CDEP
 15
Smith, Catalina
11 34,09
MAYOR
 16
Valenzuela, Daniella
12 34,14
MORRO
 15
Ojeda, Damari
13 34,28
CDUC
 15
Stein, Valentina
14 34,69
TEMUC
 15
Melinao, Constanza
15 35,45
EE
 16
Brito, Carolina
*16 35,54
MAGAL
 16
Gamboa, Kamila
*16 35,54
VIN ÑA
 15
Godoy, Kiara
18 36,51
SEREN
 15
Sanchez, Valentina
19 40,38	
 Evento 29  Mujeres 17-99 50 CL Metro Estilo de Mariposa
   Equipo	Nombre	Tiempo de Finales	
SI
 27
Perez, Paola
1 30,25  9
MAYOR
 17
Poges, Valentina
2 30,26  7
MAYOR
 19
Cea, Francisca
3 31,03  6
ATAL
 17	
Campos Hormazabal, Trinidad
4 31,05  5
ATAL
 17
Rebolledo, M. Fernanda
5 31,34  4
SF
 22
Navarro Kusch, Martina
6 31,49  3
EE
 17
Carren ño, Angela
7 31,84  2
VITAC
 19
Videla, Valeria
8 31,90  1
UNIDO
 20
Morales, Barbara
9 32,47	
 Evento 29  Mujeres 17-99 50 CL Metro Estilo de Mariposa
   Equipo	Nombre Tiempo de Finales
MAYOR
 17
Poges, Valentina
1 29,99q
SI
 27
Perez, Paola
2 31,35q
MAYOR
 19
Cea, Francisca
3 31,46q
ATAL
 17
Rebolledo, M. Fernanda
4 31,73q
SF
 22
Navarro Kusch, Martina
5 31,81q
EE
 17
Carren ño, Angela
6 31,84q
VITAC
 19
Videla, Valeria
7 31,92q
ATAL
 17
Campos Hormazabal, Trinidad
*8 32,09q
UNIDO
 20
Morales, Barbara
*8 32,09q
CDEP
 17
Cardona, Valeria
10 32,54
HUMAN
 23
Bazaez, Valeria
11 32,89
SI
 22
Zecheto, Alessia
12 32,91
EE
 19
Vicun ña, Monserrat
13 33,01
MAKO
 22
Jimenez, Margaret
14 33,02
ATAL
 20
Gutierrez, Savka
15 33,18
MAKO
 24
Olivares, Carolina
16 33,21
CDUC
 25
Chamorro, Alejandra
17 34,52

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 11
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
...   (Evento 29  Mujeres 17-99 50 CL Metro Estilo de Mariposa)	
Edad	   Equipo	Nombre Tiempo de Finales
MAYOR
 17
Crisostomo, Maira
18 34,90
VIN ÑA
 17
Viveros, Ignacia
19 35,30
CDUC
 26
Vacher, Francisca
20 37,21
MORRO
 20
Rojas, Romina
21 41,82	
 Evento 30  Hombres 13-14 50 CL Metro Estilo de Pecho
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 14
Lazzerini, Mariano
1 31,35  9
ARENA
 14
Cubillos, Vicente
2 34,00  7
WFE
 14
Crhistopher, Conus
3 34,40  6
ATAL
 14
Parada, Benjamin
4 34,57  5
TEMUC
 14
Gesche, Diego
5 34,77  4
EE
 13
Salazar, Andoni
6 35,10  3
UNIDO
 14
Lim, Sean
7 35,33  2
ARSU
 13
Gajardo, Juan Pablo
8 35,69  1
 Evento 30  Hombres 13-14 50 CL Metro Estilo de Pecho
   Equipo	Nombre Tiempo de Finales
MAYOR
 14
Lazzerini, Mariano
1 31,17q
ARENA
 14
Cubillos, Vicente
2 34,41q
WFE
 14
Crhistopher, Conus
3 34,63q
TEMUC
 14
Gesche, Diego
4 34,94q
ATAL
 14
Parada, Benjamin
5 35,00q
UNIDO
 14
Lim, Sean
6 35,36q
ARSU
 13
Gajardo, Juan Pablo
7 35,94q
EE
 13
Salazar, Andoni
8 36,13q
AUTO
 13
Gonzalez, Benjamin
9 36,40
SF
 14
Mora Orellana, Gonzalo
10 36,49
MAKO
 14
Gallardo, Sebastian
11 36,56
MAKO
 13
Barra, Benjamin
12 36,84
MAGAL
 14
Berrios, Reinaldo
13 36,89
EE
 14
Bravo, Max
14 36,94
SSWIM
 14
Ramos, Santiago
15 37,22
SI
 14
Oteiza, Antonio
16 37,50
CDEP
 14
Valderrama, Lucas
17 37,60
APS
 13
Melin Del Valle, Reiner Alario
18 38,24
CDUC
 14
Dufflocq, Julio
19 38,72
UNIDO
 14
Yan ñez, Francisco
20 39,39
COQUI
 14
Calfupan, Cristian
21 39,53
MAKO
 13
Manordes, Lucas
22 39,66
ATAL
 14
Manriquez, Joaquin
23 39,80
PEN ÑAL
 14
Godoy, Nicolas
24 40,20
HUMAN
 13
Molins, Vicente
25 40,54
MAKO
 14
Parra, Andres
26 41,02
CDUC
 14
Palma, Pablo
27 41,03
SEREN
 13
Torres, Ismael
28 42,56
EE
 14
Wensioe, Martin
29 43,10
ARENA
 13
Martinez, Tomas
30 44,08	
 Evento 31  Hombres 15-16 50 CL Metro Estilo de Pecho
   Equipo	Nombre	Tiempo de Finales	
AV
 16	
Hansen Tatter, Gerhart Nicholas
1 31,71  9
MAYOR
 16
Olivos, Joaquin
2 32,35  7
SEREN
 15
Bernal, Pacual
3 33,89  6
MAKO
 15
Dinamarca, Matias
4 34,11  5
MAYOR
 15
Urtubia, Jorge
5 34,12  4
MAYOR
 15
Aranguiz, Lucas
6 34,19  3
SEREN
 15
Navia, Matias
7 34,97  2
VIN ÑA
 16
Almonacid, Vicente
8 35,64  1	
 Evento 31  Hombres 15-16 50 CL Metro Estilo de Pecho
   Equipo	Nombre Tiempo de Finales
MAYOR
 16
Olivos, Joaquin
1 31,73q
AV
 16
Hansen Tatter, Gerhart Nicholas
2 32,35q
MAYOR
 15
Aranguiz, Lucas
3 34,35q
SEREN
 15
Navia, Matias
4 34,71q
MAYOR
 15
Urtubia, Jorge
5 35,31q
VIN ÑA
 16
Almonacid, Vicente
6 35,35q
MAKO
 15
Dinamarca, Matias
7 35,50q
SEREN
 15
Bernal, Pacual
8 35,56q
MAKO
 15
Aguirre, Matias
*9 35,99
COQUI
 16
Espinoza, Benjamin
*9 35,99
CDUC
 16
Ca áceres, Joaquin
11 36,14
ARENA
 15
Gutierrez, Nicolas
12 36,36
AMARU
 15
Meza, Matias
*13 36,67
HUMAN
 16
Camus, Patricio
*13 36,67
WFE
 15
Conus, Sergio
15 36,75
AUTO
 15
Zepeda, Agustin
16 36,91
SSWIM
 15
Castan ñon, Diego
17 37,27
MAKO
 16
Flores, Gabriel
18 37,40
CDUC
 16
Luttges, Arturo
19 38,30
ATAL
 15
Barros Palma, Benjamin
20 38,38
VICEN
 15
Gonzalez, Jorge
21 39,12
TMF
 15
Riquelme, Joaquin
22 39,86
CDUC
 16
Romero, Diego
23 40,51
SEREN
 16
Bustos, Felipe
24 41,31
APS
 16	
Castellanos Villela, Cristian Daniel
25 41,99
 Evento 32  Hombres 17-99 50 CL Metro Estilo de Pecho
   Equipo	Nombre	Tiempo de Finales	
MAKO
 26
Promo, Renato
1 27,39  9
EE
 17
Ortego, Ignacio
2 30,52  7
ATAL
 20
Furtado, Agustin
3 30,67  6
MAYOR
 17
Alvarez, Ignacio
4 30,85  5
EE
 19
Quintero, Felipe
5 31,80  4
CDUC
 19
De Andraca, Roberto
6 31,93  3
UNIDO
 17
Gil Buitrago, Antonio
7 32,55  2
SF
 18
Pin ñerua Cuevas, Carlos
8 32,89  1
 Evento 32  Hombres 17-99 50 CL Metro Estilo de Pecho
   Equipo	Nombre Tiempo de Finales
MAKO
 26
Promo, Renato
1 28,07q
MAYOR
 17
Alvarez, Ignacio
2 30,91q
EE
 17
Ortego, Ignacio
3 30,92q
EE
 19
Quintero, Felipe
4 31,43q
ATAL
 20
Furtado, Agustin
5 31,58q

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 12
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
...   (Evento 32  Hombres 17-99 50 CL Metro Estilo de Pecho)	
Edad	   Equipo	Nombre Tiempo de Finales
CDUC
 19
De Andraca, Roberto
6 32,17q
UNIDO
 17
Gil Buitrago, Antonio
7 32,74q
SF
 18
Pin ñerua Cuevas, Carlos
8 33,11q
MAYOR
 23
Sepulveda, Joaquin
9 33,15
MAYOR
 17
Aracena, Yamil
10 33,76
ATAL
 20
Escobar, Vicente
11 33,79
ARSU
 22
Diaz, Andres
12 33,83
ARAU
 17
Martinez, Eduardo
13 33,94
UNIDO
 21
Olivos, Tomas
14 34,08
EE
 32
Carriles, Francisco
15 34,28
ARSU
 17
Lara, Kevin
16 35,71
TMF
 20
Acevedo, Juan Pablo
17 35,91
MORRO
 17
Riquelme, Duam
18 35,96
ARSU
 17
Pulgar, Javier
19 36,49
ADESE
 17
De la Barra, Benjamin
20 37,45
ATAL
 22
Chavez Hidalgo, Lukas
21 37,65
SEREN
 17
Bustos, Cristobal
22 39,40	
 Evento 33  Niñas 13-14 800 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
UNIDO
 14
Custodio, Bruna
1 10:01,46  9
SSWIM
 13
Moyano, Josefina
2 10:10,34  7
SI
 14
Ramirez, Pia
3 10:24,30  6
APS
 14	
Buzolic Moreno, Tonka Alejandra
4 10:31,08  5
VITAC
 13
Alberti, Giuliana
5 10:37,93  4
MAYOR
 13
Cancino, Paz
6 10:41,89  3
SSWIM
 14
Gonza ález, Fernanda
7 10:43,61  2
SF
 13
Jara Gallegos, Sofia
8 11:04,69  1
MAGAL
 13
Valdes, Isis
9 11:15,98
ATAL
 13
Carrasco, Consuelo
10 11:33,14	
 Evento 33  Mujeres 15-16 800 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 16
Bustamante, Catalina
1 9:31,14  9
VITAC
 15
Kremer, Constanza
2 10:02,36  7
UNIDO
 15
Mondaca, Vaithiare
3 10:45,57  6
SI
 16
Collingwoord, Camila
4 10:51,31  5
SI
 15
Barrenechea, Krasna
5 11:02,33  4
VIN ÑA
 15
Arredondo, Alexandra
6 11:15,98  3	
 Evento 33  Mujeres 17-99 800 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
SI
 22
Valdivia, Mahina
1 9:31,12  9
ATAL
 17
Fuenzalida, Valentina
2 10:22,75  7
N ÑIELO
 17
Delgado, Macarena
3 10:32,12  6
ATAL
 17
Caceres, Catalina
4 10:59,38  5	
 Evento 34  Hombres 13-14 200 CL Metro Estilo de Mariposa
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 14
Menendez, Jose
1 2:20,53  9
SEREN
 14
Sepulveda, Vicente
2 2:28,86  7
AUTO
 13
Hewstone, Felipe
3 2:29,08  6
MAYOR
 13
Barriga, Sebastian
4 2:29,57  5
ATAL
 13	
Campos Hormazabal, Trinidad
5 2:31,43  4
ATAL
 14
Pavez Hormazabal, Cristian
6 2:33,24  3
MAGAL
 13
Green, Vicente
7 2:33,79  2
ATAL
 14
Parada, Benjamin
--- DQ	
 Evento 34  Hombres 13-14 200 CL Metro Estilo de Mariposa
   Equipo	Nombre Tiempo de Finales
MAYOR
 14
Menendez, Jose
1 2:23,63q
AUTO
 13
Hewstone, Felipe
2 2:32,89q
SEREN
 14
Sepulveda, Vicente
3 2:32,94q
MAYOR
 13
Barriga, Sebastian
4 2:34,94q
MAGAL
 13
Green, Vicente
5 2:35,07q
ATAL
 13
Campos Hormazabal, Trinidad
6 2:36,59q
ATAL
 14
Pavez Hormazabal, Cristian
7 2:38,58q
ATAL
 14
Parada, Benjamin
8 2:38,60q
ATAL
 13	
Pe árez Fuenzalida, Alonso Alejandro
9 2:42,52
SI
 13
Diaz, Carlos
10 2:44,36
MAKO
 13
Barraza, Bruno
11 2:45,40
ARENA
 14
Biscupovic, Nicolas
12 2:46,28
ATAL
 13
Sepu álveda, Cristobal
13 2:46,65
VITAC
 13
Pilquiman, Nicolas
14 2:48,13
ARENA
 13
Gomez, David
15 2:50,73
MAGAL
 14
Jara, Cristobal
16 2:52,94
SF
 13
Alonso Vasquez, Pablo
17 2:56,81
COQUI
 14
Calfupan, Cristian
18 3:01,22	
 Evento 35  Hombres 15-16 200 CL Metro Estilo de Mariposa
   Equipo	Nombre	Tiempo de Finales	
UNIDO
 16
Schnapp, Benjamin
1 2:09,89  9
DPA
 16
Jimenez, Felipe
2 2:11,16  7
CDUC
 15
Bobadilla, Nicolas
3 2:15,35  6
MAGAL
 16
Cespedes, Diego
4 2:15,59  5
CDEP
 15
Toledo, Luis
5 2:21,60  4
ARAU
 15
Carvajal, Luciano
6 2:31,90  3
ATAL
 16
Gonzalez Olivares, Thomas
7 2:32,23  2
WFE
 15
Conus, Sergio
8 2:34,84  1
SF
 16
Bastias Barra, Cristobal
9 2:36,03
ARSU
 16
Pfiffer, Martíán
10 2:37,64
 Evento 35  Hombres 15-16 200 CL Metro Estilo de Mariposa
   Equipo	Nombre Tiempo de Finales
UNIDO
 16
Schnapp, Benjamin
1 2:08,89q
MAGAL
 16
Cespedes, Diego
2 2:13,00q
DPA
 16
Jimenez, Felipe
3 2:14,00q
ATAL
 16
Gonzalez Olivares, Thomas
4 2:22,12q
CDUC
 15
Bobadilla, Nicolas
5 2:22,30q
CDEP
 15
Toledo, Luis
6 2:23,17q
ARAU
 15
Carvajal, Luciano
7 2:26,55q
SF
 16
Bastias Barra, Cristobal
8 2:27,45q
WFE
 15
Conus, Sergio
9 2:27,50q
ARSU
 16
Pfiffer, Martíán
10 2:32,00q	
 Evento 36  Hombres 17-99 200 CL Metro Estilo de Mariposa
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 18
Araya, Gabriel
1 2:08,28  9
MAGAL
 17
Tapia, Elian
2 2:18,39  7

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 13
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
Finales ...   (Evento 36  Hombres 17-99 200 CL Metro Estilo de Mariposa)	
Edad	   Equipo	Nombre	Tiempo de Finales	
SF
 19
Navarrete Arenas, Tomas
3 2:18,65  6
SI
 23
Quiroz, Felipe
4 2:23,74  5
HUMAN
 21
Torres, Giovanni
5 2:24,65  4	
 Evento 36  Hombres 17-99 200 CL Metro Estilo de Mariposa
   Equipo	Nombre Tiempo de Finales
MAYOR
 18
Araya, Gabriel
1 2:05,98q
HUMAN
 21
Torres, Giovanni
2 2:15,33q
SF
 19
Navarrete Arenas, Tomas
3 2:16,72q
SI
 23
Quiroz, Felipe
4 2:17,48q
MAGAL
 17
Tapia, Elian
5 2:19,00q
EE
 22
Carriles, Matias
6 2:20,01q	
 Evento 37  Mujeres 13-14 200 CL Metro Estilo de Espalda
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 14
Ardiles, Trinidad
1 2:24,69  9
CDEP
 13
Anabalon, Sofia
2 2:36,80  7
SSWIM
 13
Castro, Daniela
3 2:37,61  6
VITAC
 13
Miranda, Jennifer
4 2:42,86  5
WFE
 14
Llaupe, Janka
5 2:43,97  4
ARENA
 13
Farmer, Holly
6 2:44,65  3
MAYOR
 13
Cancino, Paz
7 2:47,79  2
SF
 13
Pizarro Brito, Isidora
--- DQ
 Evento 37  Mujeres 13-14 200 CL Metro Estilo de Espalda
   Equipo	Nombre Tiempo de Finales
MAYOR
 14
Ardiles, Trinidad
1 2:24,26q
SF
 13
Pizarro Brito, Isidora
2 2:37,94q
CDEP
 13
Anabalon, Sofia
3 2:38,35q
SSWIM
 13
Castro, Daniela
4 2:43,16q
VITAC
 13
Miranda, Jennifer
5 2:44,26q
MAYOR
 13
Cancino, Paz
6 2:44,43q
WFE
 14
Llaupe, Janka
7 2:45,36q
ARENA
 13
Farmer, Holly
8 2:48,63q
SI
 13
Barrenechea, Alemka
9 2:50,42
CDEP
 14
Solano, Sofia
10 2:52,65
MORRO
 13
Blanco, Valentina
11 2:53,64
ATAL
 13
Ortiz, Paula
12 2:55,19
MAYOR
 13
Reyes, Fernanda
13 2:56,01
SF
 13
Torres Reina, Brianna
14 2:56,55
SF
 14
Bruno Colmenares, Camila
15 2:59,85
CDEP
 13
Abate, Antonia
16 3:10,13
CDEP
 13
Mun ñoz Barrios, Emilia
--- DQ	
 Evento 38  Mujeres 15-16 200 CL Metro Estilo de Espalda
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 16
Saldes, Paloma
1 2:34,06  9
ATAL
 15
Robles, Roberta
2 2:40,61  7
WFE
 15
Martorel, Micaela
3 2:40,70  6
HUMAN
 15
Dirricarrere, Antonia
4 2:47,10  5
EE
 15
Quiroga, Renata
5 2:48,26  4
SI
 15
Gomez, Renata
6 2:48,99  3
ATAL
 16
Zamora Torres, Laura
7 2:49,14  2
ARENA
 15
Gajardo, Martina
8 2:51,76  1	
 Evento 38  Mujeres 15-16 200 CL Metro Estilo de Espalda
   Equipo	Nombre Tiempo de Finales
MAYOR
 16
Saldes, Paloma
1 2:35,22q
WFE
 15
Martorel, Micaela
2 2:42,75q
ATAL
 15
Robles, Roberta
3 2:45,29q
HUMAN
 15
Dirricarrere, Antonia
4 2:46,91q
ATAL
 16
Zamora Torres, Laura
5 2:48,39q
EE
 15
Quiroga, Renata
6 2:50,08q
ARENA
 15
Gajardo, Martina
7 2:50,20q
SI
 15
Gomez, Renata
8 2:50,55q
TEMUC
 15
Melinao, Constanza
9 2:52,72
ARAU
 15
Mendez, Martina
10 2:53,18
ARENA
 16
Reyes, Aranza
11 2:56,37
AV
 15
Medina Solis, Jazmin
12 2:58,90
CDEP
 15
Balderas, Tania
13 3:00,97
SF
 15
Palma Gajardo, Daniela
14 3:02,09	
 Evento 39  Mujeres 17-99 200 CL Metro Estilo de Espalda
   Equipo	Nombre	Tiempo de Finales	
EE
 23
Spuhr, Marianne
1 2:31,49  9
CDUC
 17
Bobadilla, Catalina
2 2:36,65  7
SI
 19
Diaz, Manuela
3 2:37,47  6
VIN ÑA
 17
Pinotti, Amanda
4 2:43,01  5
MAKO
 17
Quiroz, Fabiola
5 2:44,16  4
SI
 24
Quiroz, Bahia
6 2:46,42  3
CDEP
 17	
Hernandez Mun ñoz, Constanza	7 2:52,08  2	
 Evento 39  Mujeres 17-99 200 CL Metro Estilo de Espalda
   Equipo	Nombre Tiempo de Finales
EE
 23
Spuhr, Marianne
1 2:27,53q
CDUC
 17
Bobadilla, Catalina
2 2:32,75q
SI
 19
Diaz, Manuela
*3 2:37,31q
SI
 24
Quiroz, Bahia
*3 2:37,31q
VIN ÑA
 17
Pinotti, Amanda
5 2:38,73q
CDEP
 17
Hernandez Mun ñoz, Constanza	6 2:46,26q
MAKO
 17
Quiroz, Fabiola
7 2:48,00q	
 Evento 40  Hombres 13-14 400 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
SF
 13
Cisternas Gomez, Eduardo
1 4:16,25  9
SF
 14
Marchesini Ayala, Alejandro
2 4:19,06  7
SI
 14
Rau, Constantino
3 4:20,56  6
SI
 14
Madariaga, Lucas
4 4:21,07  5
SI
 14
Montagna, Vicente
5 4:23,09  4
SI
 13
Marin, Santiago
6 4:23,29  3
ARENA
 13
Henriquez, Martin
7 4:35,88  2
SSWIM
 14
Rojas, Joaquin
8 4:38,30  1

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 14
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
 Evento 40  Hombres 13-14 400 CL Metro Estilo Libre    Equipo	Nombre Tiempo de Finales
SI
 14
Madariaga, Lucas
1 4:24,26q
SI
 14
Rau, Constantino
2 4:25,16q
SI
 14
Montagna, Vicente
3 4:25,68q
SI
 13
Marin, Santiago
4 4:25,77q
SF
 13
Cisternas Gomez, Eduardo
5 4:26,38q
SF
 14
Marchesini Ayala, Alejandro
6 4:28,60q
SSWIM
 14
Rojas, Joaquin
7 4:38,48q
ARENA
 13
Henriquez, Martin
8 4:41,93q
UNIDO
 14
Gustin, Daniel
9 4:46,29
ARENA
 14
Castillo, Nicolas
10 4:46,72
SI
 13
Rodriguez, Agustin
11 4:48,04
N ÑIELO
 14
Saavedra, Pablo
12 4:50,96
AUTO
 13
Hewstone, Felipe
13 4:53,35
SF
 13
Pazmin ño Riffo, Alexander
14 4:56,00
AUTO
 14
Murillo, Rodrigo
15 4:57,65
CDEP
 14
Acevedo  Celedon, Matias
16 4:58,62
WFE
 14
Franco, Guillermo
17 4:58,94
ARENA
 13
Gomez, David
18 4:59,21
ATAL
 13
Pe árez Fuenzalida, Alonso Alejandro
19 5:02,02
MAKO
 14
Fernandez, Alonso
20 5:02,46
SF
 14
Tapia Aguilera, Pedro
21 5:03,03
MAKO
 14
Andalaft, Ignacio
22 5:05,13
ATAL
 14
Pavez Hormazabal, Cristian
23 5:08,13
APS
 13
Melin Del Valle, Reiner Alario
24 5:09,74
ADESE
 14
Villanueva, Enrique
25 5:10,40
TEMUC
 13
Moreno, Jose Pablo
26 5:10,46
CDEP
 14
Valderrama, Lucas
27 5:10,75
AUTO
 14
Galleguillos, Lorenzo
28 5:11,47
MAKO
 13
Manordes, Lucas
29 5:12,02
ARSU
 14
Cevo, Enzo
30 5:12,24
MAYOR
 14
Cortes, Vicente
31 5:12,90
SF
 13
Alonso Vasquez, Pablo
32 5:14,85
TEMUC
 14
Saavedra, Pablo
33 5:14,87
ATAL
 14
Manriquez, Joaquin
34 5:19,81
TMF
 13
Suarez, Pablo
35 5:21,50
EE
 14
Bravo, Max
36 5:23,36
SEREN
 13
Vega, Cristobal
37 5:23,51
MAKO
 14
Gallardo, Sebastian
38 5:27,89
CDUC
 13
Pedemonte, Facundo
39 5:30,83
MAKO
 13
Barraza, Bruno
40 5:32,13
VITAC
 13
Pilquiman, Nicolas
41 5:34,59
 Evento 41  Hombres 15-16 400 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
ATAL
 15
Martinez, Diego
1 4:16,30  9
CDEP
 15
Toledo, Luis
2 4:28,04  7
CDUC
 15
Bobadilla, Nicolas
3 4:28,06  6
ATAL
 16
Mena, Santiago
4 4:29,24  5
SI
 15
Aycauer, Vicente
5 4:31,53  4
UNIDO
 15
De la Vega, Rafael
6 4:33,79  3
CHIC-ZZ
 15
Bobadilla, Patricio
7 4:35,40  2
CDUC
 15
Dominguez, Enrique
8 4:36,91  1	
 Evento 41  Hombres 15-16 400 CL Metro Estilo Libre
   Equipo	Nombre Tiempo de Finales
ATAL
 15
Martinez, Diego
1 4:26,52q
CDUC
 15
Bobadilla, Nicolas
2 4:29,50q
CDEP
 15
Toledo, Luis
3 4:30,13q
SI
 15
Aycauer, Vicente
4 4:32,17q
ATAL
 16
Mena, Santiago
5 4:34,09q
UNIDO
 15
De la Vega, Rafael
6 4:35,22q
CHIC-ZZ
 15
Bobadilla, Patricio
7 4:35,63q
CDUC
 15
Dominguez, Enrique
8 4:35,88q
SSWIM
 15
Baeza, Nicola ás
9 4:40,82
SF
 16
Moreno Sahlie, Ignacio
10 4:41,84
UNIDO
 16
Bravo, Benjamin
11 4:42,05
WFE
 15
Martinez, Vicente
12 4:42,28
AV
 16
Salgado Suarez, Martin
13 4:44,65
MAYOR
 15
Aranguiz, Lucas
14 4:44,88
MAGAL
 15
Alvarado, Matias
15 4:47,31
VITAC
 15
Pilquiman, Matias
16 4:49,13
MAKO
 16
Flores, Gabriel
17 4:52,11
APS
 15
Gonzalez Moreno, Diego Rodrigo
18 4:52,64
MAKO
 16
Aravena, Martin
19 4:52,84
SSWIM
 15
Castan ñon, Diego
20 4:52,94
UNIDO
 15
Querales, Marcos
21 4:57,40
SI
 15
De Ferrari, Constantino
22 5:00,39
ARSU
 16
Pfiffer, Martíán
23 5:14,74
 Evento 42  Hombres 17-99 400 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
ATAL
 19
Korzeniowski, Facundo
1 4:21,58  9
UNIDO
 18
Ragazzone, Clemente
2 4:24,35  7
SI
 23
Quiroz, Felipe
3 4:25,16  6
ARSU
 17
Sotelo, Antonio
4 4:34,05  5
ARENA
 17
Soto, Nicolas
5 4:37,32  4
ATAL
 19
Iban ñez, Benjamin
6 4:41,60  3
CDEP
 17
Zagal, Jalil
7 4:42,16  2
SI
 23
Marchetti, Martin
8 4:43,57  1
 Evento 42  Hombres 17-99 400 CL Metro Estilo Libre
   Equipo	Nombre Tiempo de Finales
ATAL
 19
Korzeniowski, Facundo
1 4:25,63q
SI
 23
Quiroz, Felipe
2 4:30,42q
UNIDO
 18
Ragazzone, Clemente
3 4:34,86q
ARSU
 17
Sotelo, Antonio
4 4:35,41q
ARENA
 17
Soto, Nicolas
5 4:35,69q
ATAL
 19
Iban ñez, Benjamin
6 4:39,59q
SI
 23
Marchetti, Martin
7 4:45,96q
CDEP
 17
Zagal, Jalil
8 4:46,26q
HUMAN
 17
Retamal, Martin
9 4:47,23
HUMAN
 18
Fuentes, Marcelo
10 4:47,39
EE
 32
Carriles, Francisco
*11 4:47,56
TMF
 19
Barros, Sergio
*11 4:47,56

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 15
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
 Evento 43  Mujeres 13-14 100 CL Metro Estilo Libre    Equipo	Nombre	Tiempo de Finales	
SI
 14
Reyes, Fernanda
1 1:01,01  9
HUMAN
 14
Orellana, Sofia
2 1:02,96  7
N ÑIELO
 13
Iturriaga, Soraya
3 1:03,70  6
SI
 14
Ramirez, Pia
4 1:04,16  5
SSWIM
 13
Díáaz, Millaray
5 1:05,03  4
ATAL
 13	
Concha Marquez, Florencia Paz
6 1:05,23  3
AERO
 14
Rojas, Catalina
7 1:05,48  2
UNIDO
 14
Custodio, Bruna
8 1:06,33  1	
 Evento 43  Mujeres 13-14 100 CL Metro Estilo Libre
   Equipo	Nombre Tiempo de Finales
SI
 14
Reyes, Fernanda
1 1:02,22q
HUMAN
 14
Orellana, Sofia
2 1:03,91q
N ÑIELO
 13
Iturriaga, Soraya
3 1:04,45q
SI
 14
Ramirez, Pia
4 1:04,56q
SSWIM
 13
Díáaz, Millaray
5 1:05,31q
AERO
 14
Rojas, Catalina
6 1:05,63q
UNIDO
 14
Custodio, Bruna
7 1:05,72q
ATAL
 13
Concha Marquez, Florencia Paz
8 1:05,99q
UNIDO
 13
Bunce, Kennedy
9 1:06,25
SF
 13
Pizarro Brito, Isidora
10 1:06,26
EE
 14
Bennewitz, Catalina
11 1:07,64
MAGAL
 14
Mun ñoz, Skarlet
12 1:08,09
MAYOR
 13
Gonzales, Magdalena
13 1:08,31
VIN ÑA
 13
Araya, Florecnia
14 1:08,58
ATAL
 13
Asenjo, Renata
15 1:08,67
TEMUC
 13
Aliste, Josefina
16 1:08,72
CDEP
 13
Anabalon, Sofia
17 1:08,77
ATAL
 14
Castro Gonzalez, Antonia
18 1:08,85
CDEP
 14
Bustos, Renata Paz
19 1:09,07
PEN ÑAL
 14
Hafon, Gabriela
20 1:09,08
MAKO
 13
Yan ñez, Catalina
21 1:09,17
ARENA
 13
Molina, Natalia
22 1:09,39
APS
 13	
Ortiz Herna ández, Barbara Aracely
23 1:10,40
ATAL
 13
Carrasco, Consuelo
24 1:10,61
SI
 13
Cepeda, Maria Jesus
25 1:10,65
AV
 13
Medina, Josefa
26 1:10,79
HUMAN
 14
Moraga, Scarlette
27 1:10,91
CDUC
 13	
Delgado Noches, Isidora Antoni
28 1:10,96
LAUTA
 13
Mora, Alen
29 1:11,19
ARENA
 13
Farmer, Holly
*30 1:11,75
HUMAN
 14
Henriquez, Sofia
*30 1:11,75
VICEN
 14
Quinteros, Elizabeth
32 1:12,38
VIN ÑA
 14
Lara, Valeria
33 1:12,43
CDUC
 14
Pacheco, Renata
34 1:12,48
VITAC
 13
Miranda, Jennifer
35 1:12,52
ARAU
 13
Gil Rivera, Ana
36 1:12,76
VICEN
 14
Ahumada, Fernanda
37 1:13,35
UNIDO
 14
Gonzalez, Victoria
38 1:13,51
N ÑIELO
 13
Carrasco, Laura
39 1:13,72
ATAL
 13
Ortiz, Paula
*40 1:13,78
OHIGG
 14
Ramirez, Anais
*40 1:13,78 PEN
ÑAL
 13
Santana, Rocio
42 1:13,83
MAKO
 13
Cruz, Isidora
43 1:14,07
AUTO
 13
Cordova, Josefina
44 1:14,19
OHIGG
 13
Perromat Villacura, Martina
45 1:14,22
SEREN
 13
Diaz, Antonia
46 1:14,71
CDEP
 13
Abate, Antonia
47 1:15,15
MAGAL
 13
Romero, Francisca
48 1:15,37
CDUC
 13
Venegas, Isidora
49 1:15,45
MAYOR
 13
Reyes, Fernanda
50 1:15,68
HUMAN
 13
Diaz, Catalina
51 1:15,83
ATAL
 14
Moya Henriquez, Antonia
52 1:15,88
HUMAN
 13
Gonzalez, Catalina
53 1:16,26
AERO
 14
Corte ás, Paz
54 1:16,29
OHIGG
 14
Leiva Polanco, Sofia
55 1:16,61
VICEN
 14
Gonzalez, Isidora
56 1:17,04
SI
 13
Lagos, Rocio
57 1:17,14
APS
 13	
Sepulveda Tapia, Valentina Sofíáa
58 1:17,38
SEREN
 14
Ampuero, Daniela
59 1:23,02
MAKO
 13
Ortubia, Gabriela
60 1:27,59
 Evento 44  Mujeres 15-16 100 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
EE
 16
Marin, Ines
1 58,52  9
VIN ÑA
 15
Contreras, Gabriela
2 1:01,55  7
MAYOR
 16
Bustamante, Catalina
3 1:01,75  6
MAYOR
 16
Lewis, Diana
4 1:03,80  5
SI
 16
Zamora, Alicia
5 1:04,05  4
SEREN
 15
Carrion, Luna
*6 1:06,47  2,5
SI
 16
Collingwoord, Camila
*6 1:06,47  2,5
VIN ÑA
 15
Arredondo, Alexandra
8 1:06,53  1
MAYOR
 16
Saldes, Paloma
9 1:09,28
 Evento 44  Mujeres 15-16 100 CL Metro Estilo Libre
   Equipo	Nombre Tiempo de Finales
EE
 16
Marin, Ines
1 59,72q
VIN ÑA
 15
Contreras, Gabriela
2 1:02,54q
MAYOR
 16
Bustamante, Catalina
3 1:03,19q
MAYOR
 16
Lewis, Diana
4 1:04,05q
SI
 16
Zamora, Alicia
5 1:04,67q
SI
 16
Collingwoord, Camila
6 1:05,19q
SEREN
 15
Carrion, Luna
7 1:05,50q
MAYOR
 16
Saldes, Paloma
8 1:05,88q
VIN ÑA
 15
Arredondo, Alexandra
9 1:05,89q
VIN ÑA
 15
Araya, Sofia
10 1:05,99
OHIGG
 16
Vega Alarcon, Catalina
11 1:06,68
CDEP
 15
Llunell Vilte, Janett
12 1:06,81
MAGAL
 16
Gamboa, Kamila
13 1:07,03
ARAU
 15
Mendez, Martina
14 1:07,94
AV
 15
Medina Solis, Jazmin
15 1:08,09
MORRO
 15
Ojeda, Damari
16 1:08,45
CDUC
 15
Stein, Valentina
17 1:09,05
ARSU
 16
Seyssel, Pamela
18 1:09,65
EE
 16
Brito, Carolina
19 1:10,18
CDEP
 15
Smith, Catalina
20 1:11,07
MAYOR
 16
Valenzuela, Daniella
21 1:11,87

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 16
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
...   (Evento 44  Mujeres 15-16 100 CL Metro Estilo Libre)    Equipo	Nombre Tiempo de Finales
VIN ÑA
 15
Godoy, Kiara
22 1:13,01
ARSU
 15
Contreras, Maria Jose
23 1:13,24
OHIGG
 15
Flores, Paz
24 1:13,68
TMF
 15
Garrido, Cecilia
25 1:15,24
SEREN
 15
Sanchez, Valentina
26 1:15,53
VIN ÑA
 15
Mun ñoz, Valentina
27 1:18,29	
 Evento 45  Mujeres 17-99 100 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
MAKO
 22
Thoma, Kathi
1 1:02,34  9
SSWIM
 23
Chanuar, Leila
2 1:02,83  7
MAYOR
 17
Poges, Valentina
3 1:03,30  6
EE
 19
Vicun ña, Monserrat
4 1:03,45  5
EE
 23
Spuhr, Marianne
5 1:03,87  4
CDEP
 17
Cardona, Valeria
6 1:04,23  3
UNIDO
 17
Mauriziano, Chiara
7 1:05,28  2
ATAL
 17	
Campos Hormazabal, Trinidad
8 1:05,40  1	
 Evento 45  Mujeres 17-99 100 CL Metro Estilo Libre
   Equipo	Nombre Tiempo de Finales
SSWIM
 23
Chanuar, Leila
1 1:03,01q
MAYOR
 17
Poges, Valentina
2 1:03,44q
MAKO
 22
Thoma, Kathi
3 1:03,67q
EE
 23
Spuhr, Marianne
4 1:03,78q
EE
 19
Vicun ña, Monserrat
5 1:04,12q
UNIDO
 17
Mauriziano, Chiara
6 1:04,98q
CDEP
 17
Cardona, Valeria
7 1:05,61q
ATAL
 17
Campos Hormazabal, Trinidad
8 1:05,97q
EE
 17
Carren ño, Angela
9 1:06,02
SI
 22
Aguilar, Catalina
10 1:06,20
CDUC
 17
Bobadilla, Catalina
11 1:06,29
AUTO
 18
Zepeda, Victoria
12 1:06,37
MAYOR
 19
Cea, Francisca
13 1:06,39
VITAC
 19
Videla, Valeria
14 1:06,52
HUMAN
 23
Bazaez, Valeria
15 1:06,93
CDEP
 17	
Hernandez Mun ñoz, Constanza	16 1:07,18
ATAL
 20
Gutierrez, Savka
17 1:07,76
OHIGG
 19
Escobar Molina, Sara
18 1:07,98
ATAL
 17
Rebolledo, M. Fernanda
19 1:08,38
SI
 24
Quiroz, Bahia
20 1:08,85
MAKO
 19
Ramirez, Maria Victoria
21 1:08,93
ARSU
 17
Lopez, Rocio
22 1:09,35
VIN ÑA
 17
Gonzalez, Maylin
23 1:10,32
OHIGG
 18
Droguett M, Sofia
24 1:10,69
HUMAN
 19
Aliste, Camila
25 1:11,71
APS
 18
Bru üning Belmar, Maríáa Jose á
26 1:11,91
MORRO
 19
Rojas, Daniella
27 1:12,32
CDUC
 26
Vacher, Francisca
28 1:13,09
AERO
 17
Ulloa, Bele án
29 1:14,00
MORRO
 20
Rojas, Romina
30 1:22,43	
 Evento 46  Hombres 13-14 100 CL Metro Estilo de Espalda
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 14
Osorio, Manuel
1 1:00,91  9
HUMAN
 13
Cereceda, Maximiliano
2 1:02,46  7
CHIC-ZZ
 14
Munoz, Benjamin
3 1:03,83  6
EE
 14
Estevez, Simon
4 1:08,07  5
UNIDO
 13
Schnapp, Rafael
5 1:09,19  4
UNIDO
 14
Gustin, Daniel
6 1:09,41  3
SI
 14
Madariaga, Lucas
7 1:10,00  2
AUTO
 14
Murillo, Rodrigo
8 1:11,79  1
 Evento 46  Hombres 13-14 100 CL Metro Estilo de Espalda
   Equipo	Nombre Tiempo de Finales
MAYOR
 14
Osorio, Manuel
1 1:02,14q
HUMAN
 13
Cereceda, Maximiliano
2 1:03,35q
CHIC-ZZ
 14
Munoz, Benjamin
3 1:04,34q
EE
 14
Estevez, Simon
4 1:08,67q
UNIDO
 13
Schnapp, Rafael
5 1:09,42q
SI
 14
Madariaga, Lucas
6 1:10,04q
AUTO
 14
Murillo, Rodrigo
7 1:11,36q
UNIDO
 14
Gustin, Daniel
8 1:11,40q
MAKO
 13
Costas, Matias
9 1:11,46
SEREN
 14
Sepulveda, Vicente
10 1:12,19
N ÑIELO
 14
Saavedra, Pablo
11 1:12,40
ARENA
 14
Cubillos, Vicente
12 1:12,86
MAKO
 14
Andalaft, Ignacio
13 1:13,28
ATAL
 13
Sanchez, Sebastian
14 1:13,53
CDEP
 13
Moreno Paffetti, Martin
15 1:13,60
ARSU
 13
Caro, Ma áximo
16 1:14,86
SSWIM
 14
Annaratone, Daniel
17 1:15,63
ARENA
 13
Gatica, Leonardo
18 1:16,59
MAGAL
 13
Salazar, Alonso
19 1:16,71
ATAL
 13
Sepu álveda, Cristobal
20 1:17,28
MAYOR
 14
Cortes, Vicente
21 1:17,34
ADESE
 14
Villanueva, Enrique
22 1:18,15
MAKO
 13
Pen ña, Martin
23 1:18,71
ATAL
 14
Esteves, Emilio
24 1:19,56
ARAU
 14
Olivares, Gabriel
25 1:19,80
VITAC
 13
Venegas, Martin
26 1:20,55
SEREN
 13
Vega, Cristobal
27 1:24,02
MAKO
 13
Carrasco, Martin
28 1:24,82
TEMUC
 13
Moreno, Jose Pablo
29 1:26,85
SEREN
 13
Saez, Alex
--- DQ	
 Evento 47  Hombres 15-16 100 CL Metro Estilo de Espalda
   Equipo	Nombre	Tiempo de Finales	
SF
 15
Medina Rios, Samuel
1 1:02,28  9
MAYOR
 16
Olivos, Lucas
2 1:02,72  7
HUMAN
 16
Torres, Maximiliano
3 1:03,11  6
WFE
 15
Bratz, Octavio
4 1:03,61  5
MAYOR
 15
Reyes, Benjamin
5 1:03,68  4
MAYOR
 15
Urtubia, Jorge
6 1:03,80  3
WFE
 15
Lerzundi, Sebastian
7 1:05,14  2

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 17
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
Finales ...   (Evento 47  Hombres 15-16 100 CL Metro Estilo de Espalda)    Equipo	Nombre	Tiempo de Finales	
OHIGG
 16
Negrete, Arturo
8 1:05,17  1	
 Evento 47  Hombres 15-16 100 CL Metro Estilo de Espalda
   Equipo	Nombre Tiempo de Finales
SF
 15
Medina Rios, Samuel
1 1:03,03q
HUMAN
 16
Torres, Maximiliano
2 1:03,44q
MAYOR
 16
Olivos, Lucas
3 1:03,66q
WFE
 15
Bratz, Octavio
4 1:03,69q
MAYOR
 15
Reyes, Benjamin
5 1:04,06q
MAYOR
 15
Urtubia, Jorge
6 1:05,01q
OHIGG
 16
Negrete, Arturo
7 1:05,65q
WFE
 15
Lerzundi, Sebastian
8 1:06,95q
ARAU
 15
Araya, Pablo
9 1:07,08
MAKO
 15
Aguirre, Matias
10 1:09,35
EE
 16
Fernandez, Vicente
11 1:10,78
COQUI
 16
Espinoza, Benjamin
12 1:11,10
APS
 15
Gonzalez Moreno, Diego Rodrigo	13 1:12,34
ATAL
 15
Barros Palma, Benjamin
14 1:12,68
TMF
 16
Arias, Francisco
15 1:13,62
MAYOR
 16
Olivos, Joaquin
16 1:14,56
MAKO
 15
Dinamarca, Diego
17 1:16,97
AUTO
 16
Barrera, Juan
18 1:18,27
 Evento 48  Hombres 17-99 100 CL Metro Estilo de Espalda
   Equipo	Nombre	Tiempo de Finales	
SI
 20
Ahumada, Maximiliano
1 58,56  9
VIN ÑA
 17
Araya, Vicente
2 59,61  7
SF
 19
Perdomo Almiro án, Jose á
3 1:00,38  6
UNIDO
 18
Bustamante, Hugo
4 1:00,96  5
WFE
 17
Duarte, Lucas
5 1:01,52  4
MAYOR
 17
Aracena, Yamil
6 1:01,54  3
MAYOR
 17
Cea, Arturo
7 1:02,28  2
EE
 17
Quiroga, Augusto
8 1:02,85  1
 Evento 48  Hombres 17-99 100 CL Metro Estilo de Espalda
   Equipo	Nombre Tiempo de Finales
SI
 20
Ahumada, Maximiliano
1 59,10q
VIN ÑA
 17
Araya, Vicente
2 59,62q
SF
 19
Perdomo Almiro án, Jose á
3 1:00,48q
UNIDO
 18
Bustamante, Hugo
4 1:01,66q
WFE
 17
Duarte, Lucas
5 1:02,03q
EE
 17
Quiroga, Augusto
6 1:02,20q
MAYOR
 17
Aracena, Yamil
7 1:02,22q
MAYOR
 17
Cea, Arturo
8 1:02,27q
UNIDO
 19
Letelier, Tomas P
9 1:02,70
SI
 21
Molina, Diego
10 1:05,14
SEREN
 17
Saez, Matias
11 1:06,06
SI
 27
Isla, Alejandro
12 1:06,88
ARSU
 17
Lara, Kevin
13 1:09,65
AMARU
 17
Antiguay, Matias
14 1:10,30
CDEP
 17
Zagal, Jalil
15 1:11,23
MAKO
 22
Olea, David
16 1:16,82 VITAC
 19
Bertranou, Matias
17 1:18,09
UNIDO
 21
Quintanilla, Benjamin
--- DQ	
 Evento 49  Mujeres 13-14 400 CL Metro CI
   Equipo	Nombre	Tiempo de Finales	
SI
 14
Reyes, Fernanda
1 5:21,47  9
MAYOR
 14
Cubillos, Antonia
2 5:26,69  7
WFE
 14
Klenner, Evaluna
3 5:27,03  6
CDUC
 14
Pacheco, Matilda
4 5:37,99  5
MAGAL
 14
Andersen, Sophia
5 5:52,69  4
UNIDO
 13
Reginato, Maria Belen
6 5:56,24  3
MAYOR
 13
Solis, Paulina
7 5:58,70  2
MORRO
 13
Blanco, Valentina
8 5:58,89  1
MAGAL
 14
Ortega, Constanza
9 6:00,58
VITAC
 13
Alberti, Giuliana
10 6:03,51
UNIDO
 13
Figueroa, Amanda
11 6:15,41
APS
 14	
Buzolic Moreno, Tonka Alejandra
12 6:17,33
MAGAL
 13
Cabello, Giuliana
13 6:36,51
 Evento 50  Mujeres 15-16 400 CL Metro CI
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 15
Matsubara, Key
1 5:30,21  9
OHIGG
 16
Vega Alarcon, Catalina
2 5:37,23  7
UNIDO
 15
Mondaca, Vaithiare
3 6:01,79  6
SI
 15
Barrenechea, Krasna
--- DQ
 Evento 50  Mujeres 15-16 400 CL Metro CI
   Equipo	Nombre Tiempo de Finales
MAYOR
 15
Matsubara, Key
1 5:10,87q
OHIGG
 16
Vega Alarcon, Catalina
2 5:45,87q
SI
 15
Barrenechea, Krasna
3 5:53,68q
COQUI
 16
Rojas, Carolina
4 6:04,00q
UNIDO
 15
Mondaca, Vaithiare
5 6:09,96q	
 Evento 51  Mujeres 17-99 400 CL Metro CI
   Equipo	Nombre	Tiempo de Finales	
SI
 27
Perez, Paola
1 5:11,45  9
SI
 22
Valdivia, Mahina
2 5:35,90  7
ATAL
 17
Fuenzalida, Valentina
3 5:38,73  6
OHIGG
 19	
Pen ñailillo Alfonso, Anita Cristina
4 5:40,64  5
MAKO
 22
Thoma, Kathi
5 5:46,60  4
MAKO
 22
Jimenez, Margaret
6 5:50,03  3
ATAL
 17
Caceres, Catalina
7 6:09,54  2	
 Evento 51  Mujeres 17-99 400 CL Metro CI
   Equipo	Nombre Tiempo de Finales
SI
 27
Perez, Paola
1 5:17,15q
OHIGG
 19
Pen ñailillo Alfonso, Anita Cristina
2 5:21,00q
ATAL
 17
Fuenzalida, Valentina
3 5:24,04q
SI
 22
Valdivia, Mahina
4 5:32,15q
MAKO
 22
Thoma, Kathi
5 5:40,11q
MAKO
 22
Jimenez, Margaret
6 5:42,34q
ATAL
 17
Caceres, Catalina
7 6:02,26q

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 18
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
 Evento 52  Hombres 15-16 800 CL Metro Estilo Libre Relevo  	
Relevo	Equipo	Tiempo de Finales	
Finales A
UNIDO
2 8:40,15  14
1) De la Vega, Rafael 15 2) Querales, Marcos 15
3) Bravo, Benjamin 16 4) Schnapp, Benjamin 16
A
MAYOR
3 8:45,81  12
1) Olivos, Lucas 16 2) Reyes, Benjamin 15
3) Urtubia, Jorge 15 4) Olivos, Joaquin 16
A
ATAL
4 8:47,05  10
1) Mena, Santiago 16 2) Gonzalez Olivares, Thomas 16
3) Barros Palma, Benjamin 15 4) Martinez, Diego 15
A
MAKO
5 9:05,90  8
1) Aguirre, Matias 15 2) Dinamarca, Matias 15
3) Aravena, Martin 16 4) Flores, Gabriel 16
A
CDUC
6 9:06,18  6
1) Dominguez, Enrique 15 2) Caáceres, Joaquin 16
3) Luttges, Arturo 16 4) Bobadilla, Nicolas 15
A
CDEP
7 10:10,66  4
1) Toledo, Luis 15 2) Martinez, Sebastian 16
3) Castellanos, Cristobal 15 4) Medina, Sergio 15
 Evento 52  Hombres 15-16 800 CL Metro Estilo Libre Relevo
 	
Relevo	Equipo Tiempo de Finales
A
UNIDO
2 8:40,15q
1) De la Vega, Rafael 15 2) Querales, Marcos 15
3) Bravo, Benjamin 16 4) Schnapp, Benjamin 16
A
MAYOR
3 8:45,81q
1) Olivos, Lucas 16 2) Reyes, Benjamin 15
3) Olivos, Joaquin 16 4) Aranguiz, Lucas 15
A
ATAL
4 8:47,05q
1) Mena, Santiago 16 2) Gonzalez Olivares, Thomas 16
3) Barros Palma, Benjamin 15 4) Martinez, Diego 15
A
MAKO
5 9:05,90q
1) Aguirre, Matias 15 2) Dinamarca, Matias 15
3) Aravena, Martin 16 4) Flores, Gabriel 16
A
CDUC
6 9:06,18q
1) Dominguez, Enrique 15 2) Caáceres, Joaquin 16
3) Luttges, Arturo 16 4) Bobadilla, Nicolas 15
A
CDEP
7 10:10,66q
1) Toledo, Luis 15 2) Martinez, Sebastian 16
3) Castellanos, Cristobal 15 4) Medina, Sergio 15	
 Evento 52  Hombres 17-99 800 CL Metro Estilo Libre Relevo
 	
Relevo	Equipo	Tiempo de Finales	
Finales A
MAYOR
1 8:20,38  18
1) Aracena, Yamil 17 2) Alvarez, Ignacio 17
3) Sepulveda, Joaquin 23 4) Araya, Gabriel 18
A
EE
2 8:21,20  14
1) Varas, Carlos 26 2) Labra, Felipe 25
3) Carriles, Francisco 32 4) Cruz, Emilio 19
A
SI
3 8:23,18  12
1) Ahumada, Maximiliano 20 2) Quiroz, Felipe 23
3) Marchetti, Martin 23 4) Isla, Alejandro 27
A
UNIDO
5 8:31,06  8
1) Ragazzone, Clemente 18 2) Letelier, Tomas P 19
3) Quintanilla, Benjamin 21 4) Bustamante, Hugo 18 A
ATAL
6 8:33,02  6
1) Iban ñez, Benjamin 19 2) Prem, Juan Rodolfo 24
3) Furtado, Agustin 20 4) Korzeniowski, Facundo 19	
 Evento 52  Hombres 17-99 800 CL Metro Estilo Libre Relevo
 	
Relevo	Equipo Tiempo de Finales
A
MAYOR
1 8:20,38q
1) Aracena, Yamil 17 2) Alvarez, Ignacio 17
3) Cea, Arturo 17 4) Araya, Gabriel 18
A
EE
2 8:21,20q
1) Varas, Carlos 26 2) Labra, Felipe 25
3) Carriles, Francisco 32 4) Cruz, Emilio 19
A
SI
3 8:23,18q
1) Ahumada, Maximiliano 20 2) Isla, Alejandro 27
3) Marchetti, Martin 23 4) Pinto, Matias 22
A
UNIDO
5 8:31,06q
1) Ragazzone, Clemente 18 2) Letelier, Tomas P 19
3) Quintanilla, Benjamin 21 4) Bustamante, Hugo 18
A
ATAL
6 8:33,02q
1) Korzeniowski, Facundo 19 2) Furtado, Agustin 20
3) Chavez Hidalgo, Lukas 22 4) Ibanñez, Benjamin 19	
 Evento 53  Hombres 13-14 50 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 14
Lazzerini, Mariano
1 25,23  9
SI
 14
Madariaga, Lucas
2 26,05  7
TEMUC
 14
Gesche, Diego
3 26,27  6
CHIC-ZZ
 14
Munoz, Benjamin
4 26,84  5
UNIDO
 14
Gustin, Daniel
5 26,92  4
MAKO
 14
Andalaft, Ignacio
6 27,24  3
UNIDO
 14
Lim, Sean
7 27,67  2
SSWIM
 14
Pavez, Martíán
8 28,13  1
 Evento 53  Hombres 13-14 50 CL Metro Estilo Libre
   Equipo	Nombre Tiempo de Finales
MAYOR
 14
Lazzerini, Mariano
1 25,58q
SI
 14
Madariaga, Lucas
2 26,20q
CHIC-ZZ
 14
Munoz, Benjamin
3 26,69q
TEMUC
 14
Gesche, Diego
4 26,86q
UNIDO
 14
Gustin, Daniel
5 27,10q
UNIDO
 14
Lim, Sean
6 27,25q
MAKO
 14
Andalaft, Ignacio
7 27,69q
SSWIM
 14
Pavez, Martíán
8 27,89q
SF
 14
Tapia Aguilera, Pedro
9 27,95
AUTO
 13
Gonzalez, Benjamin
10 28,08
SSWIM
 14
Ramos, Santiago
11 28,15
CDEP
 14
Valderrama, Lucas
12 28,22
ATAL
 13
Sanchez, Sebastian
13 28,26
SSWIM
 14
Rojas, Joaquin
14 28,46
MAGAL
 14
Jara, Cristobal
15 28,53
SI
 13
Rodriguez, Agustin
16 28,66
ARENA
 14
Biscupovic, Nicolas
17 28,90
WFE
 14
Franco, Guillermo
18 29,16
MAKO
 14
Parra, Andres
19 29,22
MAKO
 14
Fernandez, Alonso
*20 29,24

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 19
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
...   (Evento 53  Hombres 13-14 50 CL Metro Estilo Libre)    Equipo	Nombre Tiempo de Finales
ARSU
 13
Mun ñoz, Bruno
*20 29,24
SI
 14
Galleguillos, Julian
22 29,46
ATAL
 14
Esteves, Emilio
23 29,55
HUMAN
 14
Henriquez, Cristian
24 29,57
MAGAL
 13
Salazar, Alonso
25 29,58
MAKO
 13
Costas, Matias
26 29,65
ARSU
 14
Cevo, Enzo
27 29,77
ADESE
 14
Villanueva, Enrique
*28 29,86
MAGAL
 13
Green, Vicente
*28 29,86
MAKO
 13
Pen ña, Martin
*30 29,87
ATAL
 14
Manriquez, Joaquin
*30 29,87
SSWIM
 14
Annaratone, Daniel
*32 29,89
VICEN
 14
Pacheco, Fernando
*32 29,89
MAKO
 13
Barra, Benjamin
34 30,02
VICEN
 14
Donoso, Cristobal
35 30,06
SI
 14
Oteiza, Antonio
36 30,37
TMF
 13
Suarez, Pablo
37 30,43
AMARU
 14
Toledo, Alberto
38 30,51
MAGAL
 14
Berrios, Reinaldo
39 30,75
APS
 14
Romero Brizuen ño, Juan Pablo Sebastian
40 30,77
MAKO
 14
Gallardo, Sebastian
41 30,82
TMF
 13
Urutia, Edgar
42 31,12
CDUC
 14
Schwerter, Federico
43 31,20
TEMUC
 14
Saavedra, Pablo
44 31,24
UNIDO
 14
Yan ñez, Francisco
45 31,28
ARENA
 13
Gatica, Leonardo
46 31,35
CDUC
 14
Urrutia, Matias
47 31,49
ARSU
 13
Caro, Ma áximo
48 31,65
EE
 14
Wensioe, Martin
49 31,79
CDEP
 14
Elgueta, Marco Antonio
50 31,86
VITAC
 13
Venegas, Martin
51 31,87
CDUC
 14
Palma, Pablo
*52 32,23
CDUC
 14
Dufflocq, Julio
*52 32,23
HUMAN
 13
Duarte, Felipe
54 32,39
TEMUC
 13
Moreno, Jose Pablo
55 32,49
CDUC
 13
Pedemonte, Facundo
56 32,56
SEREN
 13
Torres, Ismael
57 32,95
SEREN
 13
Saez, Alex
58 33,74
HUMAN
 13
Molins, Vicente
59 34,11
MAKO
 13
Carrasco, Martin
60 36,85
MAYOR
 14
Abarca, Jose
--- DQ
 Evento 54  Hombres 15-16 50 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 16
Olivos, Lucas
1 24,83  9
UNIDO
 16
Schnapp, Benjamin
2 25,22  7
HUMAN
 16
Torres, Maximiliano
3 25,61  6
CDEP
 15
Toledo, Luis
4 25,93  5
SEREN
 15
Bernal, Pacual
5 26,22  4
MAYOR
 15
Reyes, Benjamin
6 26,39  3
WFE
 15
Lerzundi, Sebastian
7 26,62  2
WFE
 15
Bratz, Octavio
8 26,66  1	
 Evento 54  Hombres 15-16 50 CL Metro Estilo Libre
   Equipo	Nombre Tiempo de Finales
MAYOR
 16
Olivos, Lucas
1 24,96q
UNIDO
 16
Schnapp, Benjamin
2 25,53q
HUMAN
 16
Torres, Maximiliano
3 25,89q
CDEP
 15
Toledo, Luis
4 26,17q
SEREN
 15
Bernal, Pacual
5 26,33q
WFE
 15
Bratz, Octavio
6 26,39q
MAYOR
 15
Reyes, Benjamin
7 26,64q
WFE
 15
Lerzundi, Sebastian
8 26,65q
OHIGG
 15
Romo, Jorge
9 26,95
SF
 16
Ortiz Mun ñoz, Vicente
10 26,97
SEREN
 15
Navia, Matias
11 27,15
UNIDO
 15
Querales, Marcos
12 27,33
SF
 16
Bastias Barra, Cristobal
13 27,57
VIN ÑA
 16
Martinez, Alexandro
14 27,60
AV
 16
Salgado Suarez, Martin
15 27,75
SSWIM
 15
Baeza, Nicola ás
16 27,88
TMF
 15
Riquelme, Joaquin
17 28,02
MAYOR
 15
Guajardo, Jose
18 28,10
CDEP
 16
Vergara, Gabriel
19 28,32
ARSU
 16
Rocamona, Ignacio
20 28,44
TMF
 16
Arias, Francisco
21 28,45
AUTO
 15
Zepeda, Agustin
22 28,47
CDUC
 15
Dominguez, Enrique
23 28,50
AMARU
 15
Meza, Matias
24 28,59
HUMAN
 16
Camus, Patricio
25 28,61
MAYOR
 16
Barraza, Paolo
26 28,66
CDUC
 16
Luttges, Arturo
27 28,71
WFE
 15
Orizola, Sebastian
28 28,99
ATAL
 15
Barros Palma, Benjamin
29 29,01
MAKO
 16
Araya, Felipe
30 29,11
MASSS
 16
Guarin, David
31 29,35
ARSU
 15
Ibarra, Fabian
32 29,37
CDUC
 16
Romero, Diego
33 29,52
APS
 16
Castellanos Villela, Cristian Daniel
34 29,59
AUTO
 16
Barrera, Juan
35 29,90
CDEP
 16
Martinez, Sebastian
36 30,05
SEREN
 16
Bustos, Felipe
37 30,54
AMARU
 16
Meza, Pablo
38 30,59
MAGAL
 15
Valenzuela, Joaquin
39 30,86
VICEN
 15
Gonzalez, Jorge
40 30,96
CDEP
 15
Castellanos, Cristobal
41 32,24
VIN ÑA
 16
Almonacid, Vicente
42 32,95
VICEN
 16
Bertolini, Franco
43 33,30
CDEP
 15
Medina, Sergio
44 33,58
 Evento 55  Hombres 17-99 50 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
MAKO
 30
Elliot, Oliver
1 23,74  9
SF
 19
Perdomo Almiro án, Jose á
2 24,20  7
EE
 26
Varas, Carlos
3 24,38  6
EE
 19
Cruz, Emilio
4 24,54  5
VIN ÑA
 17
Araya, Vicente
5 24,75  4

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 20
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
Finales ...   (Evento 55  Hombres 17-99 50 CL Metro Estilo Libre)    Equipo	Nombre	Tiempo de Finales	
MAYOR
 17
Aracena, Yamil
6 24,95  3
UNIDO
 18
Bustamante, Hugo
7 25,25  2
EE
 17
Quiroga, Augusto
8 25,47  1	
 Evento 55  Hombres 17-99 50 CL Metro Estilo Libre
   Equipo	Nombre Tiempo de Finales
SF
 19
Perdomo Almiro án, Jose á
1 24,79q
EE
 26
Varas, Carlos
2 24,81q
VIN ÑA
 17
Araya, Vicente
3 24,84q
MAKO
 30
Elliot, Oliver
4 24,87q
EE
 19
Cruz, Emilio
5 24,94q
EE
 17
Quiroga, Augusto
6 25,36q
MAYOR
 17
Aracena, Yamil
7 25,41q
UNIDO
 18
Bustamante, Hugo
8 25,45q
SI
 23
Marchetti, Martin
9 25,51
MAYOR
 23
Sepulveda, Joaquin
10 25,60
MAYOR
 17
Cea, Arturo
11 25,61
UNIDO
 18
Ragazzone, Clemente
12 25,65
WFE
 17
Duarte, Lucas
13 25,77
SI
 21
Molina, Diego
14 25,87
EE
 17
Ortego, Ignacio
15 25,90
SEREN
 17
Saez, Matias
16 25,93
UNIDO
 21
Quintanilla, Benjamin
*17 25,99
ATAL
 24
Prem, Juan Rodolfo
*17 25,99
UNIDO
 18
Lara, Joaquin
19 26,15
MAYOR
 17
Alvarez, Ignacio
20 26,20
EE
 35
Peruga, Alberto
21 26,25
SI
 23
Salazar, Felipe
22 26,40
SI
 24
Borello, Xoan
23 26,45
EE
 25
Labra, Felipe
24 26,50
EE
 26
Farias, Jose Ignacio
25 26,59
ARSU
 17
Pulgar, Javier
26 26,63
SI
 18
Carbonell, Tomas
*27 26,80
SF
 24
Navarrete Arenas, Cristobal
*27 26,80
MAKO
 17
Estay, Ignacio
29 27,02
SF
 24
Perey Fica, Javier
30 27,03
ATAL
 19
Korzeniowski, Facundo
31 27,04
HUMAN
 24
Romo, Pablo
32 27,05
MORRO
 17
Riquelme, Duam
33 27,28
ARSU
 22
Diaz, Andres
34 27,31
SI
 27
Isla, Alejandro
35 27,60
AMARU
 17
Antiguay, Matias
36 27,68
EE
 19
Fernandez, Max
37 27,72
SEREN
 17
Bustos, Cristobal
38 27,77
HUMAN
 18
Fuentes, Marcelo
39 27,85
SF
 17
Chamorro Jara, Benjamin
40 27,92
AERO
 18
Ortega, Joaquíán
41 27,95
SI
 23
Llonas, Tomas
42 28,06
ADESE
 17
De la Barra, Benjamin
43 28,41
ATAL
 20
Escobar, Vicente
44 28,53
UNIDO
 17
Jara, Felipe
45 28,54
VICEN
 17
Toledo, Alavro
46 28,71
MAKO
 18
Lucares, Alejandro
47 28,85
MAKO
 22
Olea, David
48 29,15 ARSU
 18
Gallardo, Joaquin
49 29,24
ATAL
 24	
Gonzalez Rojas, Claudio Matias	50 29,27
VITAC
 19
Bertranou, Matias
51 30,75
 Evento 56  Mujeres 13-14 50 CL Metro Estilo de Espalda
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 14
Ardiles, Trinidad
1 32,47  9
SF
 13
Pizarro Brito, Isidora
2 33,15  7
ATAL
 13	
Concha Marquez, Florencia Paz	3 33,67  6
CDEP
 13
Anabalon, Sofia
4 33,98  5
SSWIM
 13
Castro, Daniela
5 34,08  4
MAYOR
 13
Gonzales, Magdalena
6 34,32  3
CDEP
 14
Solano, Sofia
7 35,07  2
WFE
 14
Llaupe, Janka
8 35,31  1	
 Evento 56  Mujeres 13-14 50 CL Metro Estilo de Espalda
   Equipo	Nombre Tiempo de Finales
MAYOR
 14
Ardiles, Trinidad
1 31,83q
SF
 13
Pizarro Brito, Isidora
2 33,06q
MAYOR
 13
Gonzales, Magdalena
3 34,60q
SSWIM
 13
Castro, Daniela
4 34,61q
ATAL
 13
Concha Marquez, Florencia Paz	5 34,68q
WFE
 14
Llaupe, Janka
6 34,88q
CDEP
 13
Anabalon, Sofia
7 35,13q
CDEP
 14
Solano, Sofia
8 35,16q
APS
 14	
Buzolic Moreno, Tonka Alejandra
9 35,91
ARENA
 13
Farmer, Holly
10 36,08
VIN ÑA
 13
Araya, Florecnia
11 36,26
MAYOR
 13
Cancino, Paz
12 36,41
VICEN
 14
Quinteros, Elizabeth
13 36,62
AERO
 14
Rojas, Catalina
14 36,66
ARENA
 13
Ampuero, Martina
15 36,75
SF
 13
Torres Reina, Brianna
16 37,15
ARSU
 14
Pulgar, Antonia
17 37,16
VITAC
 13
Miranda, Jennifer
18 37,17
MAYOR
 13
Saldes, Paz
19 37,35
SF
 14
Bruno Colmenares, Camila
20 37,36
ARENA
 14
Perez, Francisca
21 37,50
MAYOR
 13
Reyes, Fernanda
22 37,60
ATAL
 13
Asenjo, Renata
23 37,80
HUMAN
 14
Moraga, Scarlette
24 38,26
MAKO
 13
Yan ñez, Catalina
25 38,28
APS
 13	
Ortiz Herna ández, Barbara Aracely
26 38,64
SEREN
 13
Diaz, Antonia
27 39,10
VICEN
 13
Hansen, Andra
28 39,46
ATAL
 13
Carrasco, Consuelo
29 39,47
APS
 14	
Gonzalez Vega, Francisca Antonia	30 41,38
CDEP
 13
Abate, Antonia
31 41,47
ATAL
 14
Moya Henriquez, Antonia
32 41,94
SI
 13
Lagos, Rocio
33 42,47
VICEN
 13
Hansen, Anke
34 43,47
SEREN
 14
Ampuero, Daniela
35 44,58
MAKO
 13
Ortubia, Gabriela
36 44,87
VICEN
 14
Ahumada, Fernanda
--- DQ

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 21
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
 Evento 57  Mujeres 15-16 50 CL Metro Estilo de Espalda    Equipo	Nombre	Tiempo de Finales	
EE
 16
Marin, Ines
1 31,85  9
MAYOR
 16
Saldes, Paloma
2 32,64  7
VIN ÑA
 15
Araya, Sofia
3 33,47  6
MAYOR
 16
Valdes, Javiera
4 33,66  5
SEREN
 15
Carrion, Luna
5 33,86  4
ARENA
 16
Medina, Cosntanza
6 34,08  3
AV
 16
Gomez Fett, Paulina
7 34,89  2
ATAL
 15
Robles, Roberta
8 35,11  1
EE
 15
Quiroga, Renata
9 35,40
 Evento 57  Mujeres 15-16 50 CL Metro Estilo de Espalda
   Equipo	Nombre Tiempo de Finales
EE
 16
Marin, Ines
1 32,27q
MAYOR
 16
Saldes, Paloma
2 32,99q
MAYOR
 16
Valdes, Javiera
3 34,14q
SEREN
 15
Carrion, Luna
4 34,25q
ATAL
 15
Robles, Roberta
5 34,98q
AV
 16
Gomez Fett, Paulina
6 35,01q
VIN ÑA
 15
Araya, Sofia
7 35,11q
ARENA
 16
Medina, Cosntanza
*8 35,13q
EE
 15
Quiroga, Renata
*8 35,13q
ARENA
 16
Reyes, Aranza
10 35,37
ATAL
 16
Zamora Torres, Laura
11 35,42
SI
 15
Gomez, Renata
12 35,51
AV
 15
Medina Solis, Jazmin
13 35,57
CDEP
 15
Llunell Vilte, Janett
14 36,19
TEMUC
 15
Melinao, Constanza
15 36,28
HUMAN
 15
Dirricarrere, Antonia
16 36,78
ARENA
 15
Gajardo, Martina
17 37,49
ARSU
 16
Seyssel, Pamela
18 37,84
MAYOR
 16
Valdes, Fernanda
19 38,00
ARAU
 15
Mendez, Martina
20 38,06
CDUC
 15
Stein, Valentina
*21 39,00
SEREN
 15
Sanchez, Valentina
*21 39,00
SF
 15
Palma Gajardo, Daniela
23 39,17
CDEP
 16
Mun ñoz, Matilde
24 39,49
VIN ÑA
 15
Mun ñoz, Valentina
25 41,31	
 Evento 58  Mujeres 17-99 50 CL Metro Estilo de Espalda
   Equipo	Nombre	Tiempo de Finales	
SI
 19
Diaz, Manuela
1 32,45  9
MAYOR
 19
Cea, Francisca
*2 33,24  6,5
EE
 23
Spuhr, Marianne
*2 33,24  6,5
ATAL
 23
Bravo, Claudia
4 33,58  5
UNIDO
 17
Mauriziano, Chiara
5 34,08  4
ATAL
 17	
Campos Hormazabal, Trinidad
6 34,81  3
CDUC
 17
Bobadilla, Catalina
7 34,98  2
ATAL
 17
Rebolledo, M. Fernanda
8 36,19  1	
 Evento 58  Mujeres 17-99 50 CL Metro Estilo de Espalda
   Equipo	Nombre Tiempo de Finales
MAYOR
 19
Cea, Francisca
1 33,28q
EE
 23
Spuhr, Marianne
2 33,37q
SI
 19
Diaz, Manuela
3 33,53q
ATAL
 23
Bravo, Claudia
4 33,69q
UNIDO
 17
Mauriziano, Chiara
5 34,50q
CDUC
 17
Bobadilla, Catalina
6 34,70q
ATAL
 17
Campos Hormazabal, Trinidad
7 35,85q
ATAL
 17
Rebolledo, M. Fernanda
8 36,18q
SI
 24
Quiroz, Bahia
9 36,30
UNIDO
 20
Morales, Barbara
10 36,42
MAKO
 17
Quiroz, Fabiola
11 36,55
SI
 22
Aguilar, Catalina
12 36,76
CDUC
 20
Castro, Francisca
13 36,95
AERO
 17
Ulloa, Bele án
14 37,29
OHIGG
 18
Droguett M, Sofia
15 37,77
MORRO
 19
Rojas, Daniella
16 38,89
VIN ÑA
 21
Toledo, Paulina
17 38,90
OHIGG
 17
Pen ñailillo Alfonso, Isidora
--- DQ
SI
 28
Reyes, Daniela
--- DQ	
 Evento 59  Niños 13-14 1500 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
SI
 14
Rau, Constantino
1 16:55,27  9
SF
 13
Cisternas Gomez, Eduardo
2 17:09,57  7
SI
 13
Marin, Santiago
3 17:27,96  6
SI
 14
Montagna, Vicente
4 17:44,30  5
SF
 14
Marchesini Ayala, Alejandro
5 17:54,45  4
ATAL
 13	
Campos Hormazabal, Trinidad
6 18:37,49  3
ATAL
 13	
Pe árez Fuenzalida, Alonso Alejandro
7 19:22,77  2
SF
 13
Pazmin ño Riffo, Alexander
8 19:50,24  1
ATAL
 14
Pavez Hormazabal, Cristian
9 19:53,80
ARENA
 13
Gomez, David
10 20:15,63
SF
 13
Alonso Vasquez, Pablo
11 20:18,64
ARSU
 14
Cevo, Enzo
12 20:45,84	
 Evento 59  Hombres 15-16 1500 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
ATAL
 15
Martinez, Diego
1 17:05,15  9
UNIDO
 15
De la Vega, Rafael
2 18:02,01  7
SI
 15
Aycauer, Vicente
3 18:16,69  6
MAGAL
 15
Alvarado, Matias
4 18:24,25  5
UNIDO
 15
Querales, Marcos
5 18:25,70  4
CHIC-ZZ
 15
Bobadilla, Patricio
6 18:35,58  3
SF
 16
Moreno Sahlie, Ignacio
7 18:38,19  2
VITAC
 15
Pilquiman, Matias
8 19:04,87  1	
 Evento 59  Hombres 17-99 1500 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
ATAL
 19
Korzeniowski, Facundo
1 16:55,22  9
ARSU
 17
Sotelo, Antonio
2 18:26,65  7
ARENA
 17
Soto, Nicolas
3 18:28,78  6
UNIDO
 18
Ragazzone, Clemente
4 18:37,82  5
SI
 20
Cavada, Ignacio
5 18:38,14  4
TMF
 19
Barros, Sergio
6 18:47,08  3

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 22
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
 Evento 60  Mujeres 13-14 200 CL Metro Estilo de Pecho    Equipo	Nombre	Tiempo de Finales	
MAYOR
 14
Cubillos, Antonia
1 2:43,89  9
SSWIM
 13
Moyano, Josefina
2 2:56,02  7
EE
 14
Bennewitz, Catalina
3 2:57,81  6
ARENA
 13
Molina, Natalia
4 3:00,51  5
VITAC
 13
Alberti, Giuliana
5 3:05,27  4
MAYOR
 13
Solis, Paulina
6 3:05,36  3
UNIDO
 13
Reginato, Maria Belen
7 3:05,55  2
MORRO
 13
Blanco, Valentina
8 3:14,32  1
 Evento 60  Mujeres 13-14 200 CL Metro Estilo de Pecho
   Equipo	Nombre Tiempo de Finales
MAYOR
 14
Cubillos, Antonia
1 2:45,24q
SSWIM
 13
Moyano, Josefina
2 2:56,48q
ARENA
 13
Molina, Natalia
3 2:59,05q
EE
 14
Bennewitz, Catalina
4 2:59,57q
MAYOR
 13
Solis, Paulina
5 3:02,08q
VITAC
 13
Alberti, Giuliana
6 3:03,57q
UNIDO
 13
Reginato, Maria Belen
7 3:07,73q
MORRO
 13
Blanco, Valentina
8 3:12,77q
CDEP
 14
Bustos, Renata Paz
9 3:19,87
MAYOR
 13
Saldes, Paz
10 3:21,15
LAUTA
 13
Mora, Alen
11 3:26,02
APS
 13
Sepulveda Tapia, Valentina Sofíáa
12 3:31,56
CDEP
 14
Solano, Sofia
13 3:34,06
OHIGG
 14
Leiva Polanco, Sofia
14 3:35,02
AUTO
 13
Cordova, Josefina
15 3:39,59
OHIGG
 13
Perromat Villacura, Martina
16 3:50,79
AMARU
 14
Armijo, Almendra
17 3:54,28
HUMAN
 14
Henriquez, Sofia
--- DQ
 Evento 61  Mujeres 15-16 200 CL Metro Estilo de Pecho
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 15
Matsubara, Key
1 2:50,03  9
MAYOR
 15
Palomino, Naiomi
2 2:57,40  7
MAKO
 16
Acun ña, Sofia
3 3:27,86  6
ARENA
 16
Medina, Cosntanza
--- DQ
CDUC
 15
Pen ña, Beatriz
--- DQ
 Evento 61  Mujeres 15-16 200 CL Metro Estilo de Pecho
   Equipo	Nombre Tiempo de Finales
MAYOR
 15
Matsubara, Key
1 2:48,98q
MAYOR
 15
Palomino, Naiomi
2 2:54,54q
ARENA
 16
Medina, Cosntanza
3 2:56,01q
MAKO
 16
Acun ña, Sofia
4 3:10,23q
CDUC
 15
Pen ña, Beatriz
5 3:12,30q	
 Evento 62  Mujeres 17-99 200 CL Metro Estilo de Pecho
   Equipo	Nombre	Tiempo de Finales	
HUMAN
 20
Pinto, Javiera
1 2:53,75  9
ATAL
 17
Fuenzalida, Valentina
2 2:57,32  7
OHIGG
 19	
Pen ñailillo Alfonso, Anita Cristina
3 2:58,77  6
SEREN
 18
Torres, Pamela
4 3:02,77  5
ARSU
 17
Lopez, Rocio
5 3:11,38  4
SI
 22
Zecheto, Alessia
6 3:21,61  3
N ÑIELO
 17
Delgado, Macarena
7 3:24,11  2
MAYOR
 17
Crisostomo, Maira
8 3:24,93  1
AUTO
 18
Zepeda, Victoria
--- DQ	
 Evento 62  Mujeres 17-99 200 CL Metro Estilo de Pecho
   Equipo	Nombre Tiempo de Finales
MAYOR
 17
Crisostomo, Maira
1 2:10,65q
HUMAN
 20
Pinto, Javiera
2 2:49,29q
OHIGG
 19
Pen ñailillo Alfonso, Anita Cristina
3 2:52,82q
AUTO
 18
Zepeda, Victoria
4 2:55,30q
ATAL
 17
Fuenzalida, Valentina
5 2:56,57q
SEREN
 18
Torres, Pamela
6 3:00,00q
ARSU
 17
Lopez, Rocio
7 3:02,00q
N ÑIELO
 17
Delgado, Macarena
8 3:11,45q
SI
 22
Zecheto, Alessia
9 3:12,03q	
 Evento 63  Hombres 13-14 100 CL Metro Estilo de Mariposa
   Equipo	Nombre	Tiempo de Finales	
HUMAN
 13
Cereceda, Maximiliano
1 1:00,67  9
SF
 13
Cisternas Gomez, Eduardo
2 1:01,83  7
MAYOR
 14
Menendez, Jose
3 1:02,34  6
SEREN
 14
Sepulveda, Vicente
4 1:06,12  5
AUTO
 13
Hewstone, Felipe
5 1:06,21  4
EE
 14
Estevez, Simon
6 1:06,58  3
MAGAL
 14
Jara, Cristobal
7 1:06,89  2
SI
 14
Rau, Constantino
8 1:07,04  1
 Evento 63  Hombres 13-14 100 CL Metro Estilo de Mariposa
   Equipo	Nombre Tiempo de Finales
HUMAN
 13
Cereceda, Maximiliano
1 1:01,95q
SF
 13
Cisternas Gomez, Eduardo
2 1:02,00q
MAYOR
 14
Menendez, Jose
3 1:02,08q
SEREN
 14
Sepulveda, Vicente
4 1:05,38q
EE
 14
Estevez, Simon
5 1:05,42q
SI
 14
Rau, Constantino
6 1:06,45q
AUTO
 13
Hewstone, Felipe
7 1:06,65q
MAGAL
 14
Jara, Cristobal
8 1:07,59q
ARENA
 14
Biscupovic, Nicolas
9 1:07,61
WFE
 14
Crhistopher, Conus
10 1:08,04
ATAL
 14
Parada, Benjamin
11 1:08,23
ATAL
 14
Pavez Hormazabal, Cristian
12 1:08,28
MAYOR
 13
Barriga, Sebastian
13 1:09,85
MAGAL
 13
Green, Vicente
14 1:10,05
ATAL
 13
Sepu álveda, Cristobal
15 1:10,16
EE
 13
Salazar, Andoni
16 1:10,68
SI
 13
Diaz, Carlos
17 1:12,11
WFE
 14
Franco, Guillermo
18 1:12,35
COQUI
 14
Calfupan, Cristian
19 1:13,24
CDUC
 14
Palma, Pablo
20 1:14,62
VITAC
 13
Pilquiman, Nicolas
21 1:14,70

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 23
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
...   (Evento 63  Hombres 13-14 100 CL Metro Estilo de Mariposa)	
Edad	   Equipo	Nombre Tiempo de Finales
SI
 14
Galleguillos, Julian
22 1:17,16
ARAU
 14
Olivares, Gabriel
23 1:19,89
ARENA
 13
Gomez, David
24 1:21,21	
 Evento 64  Hombres 15-16 100 CL Metro Estilo de Mariposa
   Equipo	Nombre	Tiempo de Finales	
UNIDO
 16
Schnapp, Benjamin
1 57,24  9
MAGAL
 16
Cespedes, Diego
2 59,95  7
DPA
 16
Jimenez, Felipe
3 1:00,23  6
CDEP
 15
Toledo, Luis
4 1:00,76  5
WFE
 15
Conus, Sergio
5 1:03,50  4
ATAL
 16
Mena, Santiago
6 1:03,57  3
SF
 16
Bastias Barra, Cristobal
7 1:03,94  2
WFE
 15
Martinez, Vicente
8 1:07,13  1
 Evento 64  Hombres 15-16 100 CL Metro Estilo de Mariposa
   Equipo	Nombre Tiempo de Finales
UNIDO
 16
Schnapp, Benjamin
1 58,82q
MAGAL
 16
Cespedes, Diego
2 1:00,97q
DPA
 16
Jimenez, Felipe
3 1:01,82q
CDEP
 15
Toledo, Luis
4 1:02,08q
ATAL
 16
Mena, Santiago
5 1:03,86q
WFE
 15
Conus, Sergio
6 1:04,10q
SF
 16
Bastias Barra, Cristobal
7 1:05,16q
WFE
 15
Martinez, Vicente
8 1:06,50q
VIN ÑA
 16
Martinez, Alexandro
9 1:08,09
OHIGG
 15
Romo, Jorge
10 1:08,21
WFE
 15
Orizola, Sebastian
11 1:08,49
ARAU
 15
Carvajal, Luciano
12 1:08,59
ARSU
 16
Pfiffer, Martíán
13 1:09,05
ARAU
 15
Araya, Pablo
14 1:09,33
AMARU
 16
Zabala, Joaquin
15 1:09,58
MAKO
 16
Aravena, Martin
16 1:10,18
HUMAN
 15
Agurto, Lucas
17 1:10,43
ATAL
 16
Gonzalez Olivares, Thomas
18 1:11,31
MAKO
 16
Araya, Felipe
19 1:13,28
APS
 16
Castellanos Villela, Cristian Daniel
20 1:17,48
 Evento 65  Hombres 17-99 100 CL Metro Estilo de Mariposa
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 18
Araya, Gabriel
1 56,69  9
EE
 19
Cruz, Emilio
2 58,23  7
MAYOR
 23
Sepulveda, Joaquin
3 58,37  6
MAYOR
 17
Aracena, Yamil
4 59,40  5
WFE
 17
Duarte, Lucas
5 59,65  4
EE
 17
Quiroga, Augusto
6 1:00,18  3
SF
 19
Navarrete Arenas, Tomas
7 1:00,24  2
CDUC
 23
Saavedra, Diego
8 1:01,44  1
 Evento 65  Hombres 17-99 100 CL Metro Estilo de Mariposa
   Equipo	Nombre Tiempo de Finales
MAYOR
 18
Araya, Gabriel
1 58,15q EE
 19
Cruz, Emilio
2 58,42q
WFE
 17
Duarte, Lucas
3 1:00,49q
EE
 17
Quiroga, Augusto
4 1:00,57q
MAYOR
 23
Sepulveda, Joaquin
5 1:00,61q
MAYOR
 17
Aracena, Yamil
6 1:00,81q
SF
 19
Navarrete Arenas, Tomas
7 1:00,96q
CDUC
 23
Saavedra, Diego
8 1:01,77q
MAGAL
 17
Tapia, Elian
9 1:01,93
UNIDO
 21
Quintanilla, Benjamin
10 1:02,59
SI
 27
Isla, Alejandro
11 1:03,04
MAYOR
 18
Azocar, Matias
12 1:03,13
SI
 18
Carbonell, Tomas
13 1:03,30
MAYOR
 17
Cea, Arturo
14 1:03,61
MAKO
 17
Estay, Ignacio
15 1:04,95
MAYOR
 17
Alvarez, Ignacio
16 1:05,09
ARSU
 17
Lara, Kevin
17 1:05,61
AMARU
 17
Antiguay, Matias
18 1:06,79
MAKO
 18
Lucares, Alejandro
19 1:10,37
HUMAN
 21
Torres, Giovanni
20 1:11,39
ATAL
 24	
Gonzalez Rojas, Claudio Matias	21 1:14,56
 Evento 66  Mujeres 13-14 200 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
SI
 14
Reyes, Fernanda
1 2:16,96  9
HUMAN
 14
Orellana, Sofia
2 2:17,89  7
SI
 14
Ramirez, Pia
3 2:18,10  6
UNIDO
 14
Custodio, Bruna
4 2:19,48  5
N ÑIELO
 13
Iturriaga, Soraya
5 2:23,73  4
SSWIM
 14
Gonza ález, Fernanda
6 2:24,86  3
SF
 13
Pizarro Brito, Isidora
7 2:25,03  2
SSWIM
 13
Díáaz, Millaray
8 2:25,12  1
 Evento 66  Mujeres 13-14 200 CL Metro Estilo Libre
   Equipo	Nombre Tiempo de Finales
HUMAN
 14
Orellana, Sofia
1 2:19,44q
SI
 14
Reyes, Fernanda
2 2:19,73q
SI
 14
Ramirez, Pia
3 2:21,08q
UNIDO
 14
Custodio, Bruna
4 2:21,10q
N ÑIELO
 13
Iturriaga, Soraya
5 2:21,11q
SF
 13
Pizarro Brito, Isidora
6 2:24,24q
SSWIM
 14
Gonza ález, Fernanda
7 2:26,28q
SSWIM
 13
Díáaz, Millaray
8 2:26,71q
SSWIM
 13
Castro, Daniela
9 2:27,70
WFE
 14
Llaupe, Janka
10 2:28,52
UNIDO
 13
Bunce, Kennedy
11 2:29,05
APS
 13
Ortiz Herna ández, Barbara Aracely
12 2:29,60
TEMUC
 13
Aliste, Josefina
13 2:29,67
CDEP
 13
Anabalon, Sofia
14 2:29,98
MAYOR
 13
Cancino, Paz
15 2:30,60
AERO
 14
Rojas, Catalina
16 2:31,14
SI
 13
Barrenechea, Alemka
17 2:31,80
ATAL
 14
Castro Gonzalez, Antonia
18 2:35,51
CDUC
 13	
Delgado Noches, Isidora Antonia	19 2:37,19
SF
 13
Jara Gallegos, Sofia
20 2:37,93
ARAU
 13
Gil Rivera, Ana
21 2:38,79

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 24
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
...   (Evento 66  Mujeres 13-14 200 CL Metro Estilo Libre)    Equipo	Nombre Tiempo de Finales
AV
 13
Medina, Josefa
22 2:38,98
HUMAN
 14
Moraga, Scarlette
23 2:39,41
OHIGG
 14
Ramirez, Anais
24 2:43,41
CDUC
 13
Venegas, Isidora
25 2:45,61
SF
 13
Torres Reina, Brianna
26 2:45,91
MAGAL
 13
Cabello, Giuliana
27 2:46,82
OHIGG
 13
Perromat Villacura, Martina
28 2:48,23
MAGAL
 13
Romero, Francisca
29 2:49,81
CDEP
 13
Abate, Antonia
30 2:51,15
PEN ÑAL
 13
Santana, Rocio
31 2:52,09
AUTO
 13
Cordova, Josefina
32 2:57,28
SSWIM
 13
Moyano, Josefina
--- X2:24,02	
 Evento 67  Mujeres 15-16 200 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 16
Bustamante, Catalina
1 2:12,75  9
VIN ÑA
 15
Contreras, Gabriela
2 2:13,52  7
MAYOR
 16
Lewis, Diana
3 2:15,22  6
SI
 16
Collingwoord, Camila
4 2:23,44  5
SI
 16
Zamora, Alicia
5 2:24,04  4
VIN ÑA
 15
Arredondo, Alexandra
6 2:24,40  3
OHIGG
 16
Vega Alarcon, Catalina
7 2:26,10  2
UNIDO
 15
Mondaca, Vaithiare
8 2:28,13  1
 Evento 67  Mujeres 15-16 200 CL Metro Estilo Libre
   Equipo	Nombre Tiempo de Finales
MAYOR
 16
Bustamante, Catalina
1 2:17,74q
VIN ÑA
 15
Contreras, Gabriela
2 2:18,09q
MAYOR
 16
Lewis, Diana
3 2:18,27q
SI
 16
Collingwoord, Camila
4 2:24,33q
VIN ÑA
 15
Arredondo, Alexandra
5 2:26,22q
OHIGG
 16
Vega Alarcon, Catalina
6 2:26,49q
SI
 16
Zamora, Alicia
7 2:27,24q
UNIDO
 15
Mondaca, Vaithiare
8 2:27,35q
MAGAL
 16
Gamboa, Kamila
9 2:27,49
ARAU
 15
Mendez, Martina
10 2:29,29
SEREN
 15
Carrion, Luna
11 2:30,53
AV
 16
Gomez Fett, Paulina
12 2:31,35
ARSU
 16
Seyssel, Pamela
13 2:32,34
CDEP
 15
Llunell Vilte, Janett
14 2:33,98
EE
 16
Brito, Carolina
15 2:37,84
CDUC
 15
Stein, Valentina
16 2:43,41
VIN ÑA
 15
Godoy, Kiara
17 2:44,32	
 Evento 68  Mujeres 17-99 200 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
SI
 22
Valdivia, Mahina
1 2:13,97  9
ATAL
 17
Fuenzalida, Valentina
2 2:17,30  7
MAKO
 22
Thoma, Kathi
3 2:19,21  6
CDUC
 17
Bobadilla, Catalina
4 2:23,16  5
SF
 22
Navarro Kusch, Martina
5 2:23,25  4
CDEP
 17	
Hernandez Mun ñoz, Constanza
6 2:24,73  3
MAKO
 19
Ramirez, Maria Victoria
7 2:28,26  2
N ÑIELO
 17
Delgado, Macarena
8 2:31,01  1	
 Evento 68  Mujeres 17-99 200 CL Metro Estilo Libre
   Equipo	Nombre Tiempo de Finales
SI
 22
Valdivia, Mahina
1 2:19,30q
ATAL
 17
Fuenzalida, Valentina
2 2:20,15q
MAKO
 22
Thoma, Kathi
3 2:21,01q
SF
 22
Navarro Kusch, Martina
4 2:23,21q
N ÑIELO
 17
Delgado, Macarena
5 2:23,34q
CDUC
 17
Bobadilla, Catalina
6 2:23,87q
CDEP
 17
Hernandez Mun ñoz, Constanza	7 2:25,32q
MAKO
 19
Ramirez, Maria Victoria
8 2:28,70q
CDEP
 17
Cardona, Valeria
9 2:30,37
HUMAN
 23
Bazaez, Valeria
10 2:31,39
SI
 22
Aguilar, Catalina
11 2:32,19
OHIGG
 19
Escobar Molina, Sara
12 2:33,04
VIN ÑA
 21
Toledo, Paulina
13 2:37,89
VIN ÑA
 17
Gonzalez, Maylin
14 2:38,17
CDUC
 26
Vacher, Francisca
15 2:38,39
HUMAN
 19
Aliste, Camila
16 2:40,67
CDUC
 25
Chamorro, Alejandra
17 2:45,35
MORRO
 19
Rojas, Daniella
18 2:47,41
MORRO
 20
Rojas, Romina
19 3:05,87
MAKO
 22
Jimenez, Margaret
--- X2:25,68	
 Evento 69  Hombres 13-14 200 CL Metro CI
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 14
Osorio, Manuel
1 2:18,20  9
MAYOR
 14
Menendez, Jose
2 2:22,90  7
WFE
 14
Crhistopher, Conus
3 2:26,58  6
SI
 14
Montagna, Vicente
4 2:27,28  5
ATAL
 13	
Campos Hormazabal, Trinidad
5 2:30,56  4
AUTO
 13
Hewstone, Felipe
6 2:32,18  3
ARENA
 13
Henriquez, Martin
7 2:33,21  2
ARENA
 14
Cubillos, Vicente
8 2:35,39  1	
 Evento 69  Hombres 13-14 200 CL Metro CI
   Equipo	Nombre Tiempo de Finales
MAYOR
 14
Osorio, Manuel
1 2:23,81q
MAYOR
 14
Menendez, Jose
2 2:24,43q
SI
 14
Montagna, Vicente
3 2:26,77q
ARENA
 13
Henriquez, Martin
4 2:32,07q
ATAL
 13
Campos Hormazabal, Trinidad
5 2:32,34q
WFE
 14
Crhistopher, Conus
6 2:32,71q
AUTO
 13
Hewstone, Felipe
7 2:33,03q
ARENA
 14
Cubillos, Vicente
8 2:34,28q
AUTO
 13
Gonzalez, Benjamin
9 2:35,10
ARENA
 14
Castillo, Nicolas
10 2:35,99
EE
 13
Salazar, Andoni
11 2:36,39
AUTO
 14
Murillo, Rodrigo
12 2:36,68
ATAL
 13
Sanchez, Sebastian
13 2:38,26
UNIDO
 13
Schnapp, Rafael
14 2:38,28
N ÑIELO
 14
Saavedra, Pablo
15 2:38,75

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 25
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
...   (Evento 69  Hombres 13-14 200 CL Metro CI)    Equipo	Nombre Tiempo de Finales
APS
 13
Melin Del Valle, Reiner Alario
16 2:38,78
MAKO
 13
Costas, Matias
17 2:39,11
CDEP
 14
Acevedo  Celedon, Matias
18 2:40,04
CDEP
 13
Moreno Paffetti, Martin
19 2:41,41
ATAL
 13
Pe árez Fuenzalida, Alonso Alejandro
20 2:43,00
MAKO
 13
Barra, Benjamin
21 2:43,38
AUTO
 14
Galleguillos, Lorenzo
22 2:43,96
ATAL
 13
Sepu álveda, Cristobal
23 2:45,95
MAKO
 13
Manordes, Lucas
24 2:47,00
MAKO
 14
Fernandez, Alonso
25 2:48,36
ARSU
 13
Caro, Ma áximo
26 2:50,65
COQUI
 14
Calfupan, Cristian
27 2:52,55
MAKO
 13
Pen ña, Martin
28 2:53,05
EE
 14
Wensioe, Martin
29 2:55,56
SEREN
 13
Vega, Cristobal
30 2:56,15
PEN ÑAL
 14
Godoy, Nicolas
31 2:58,23
MAKO
 13
Carrasco, Martin
32 3:07,44
SEREN
 13
Torres, Ismael
33 3:22,82
 Evento 70  Hombres 15-16 200 CL Metro CI
   Equipo	Nombre	Tiempo de Finales	
ATAL
 15
Martinez, Diego
1 2:15,93  9
SF
 15
Medina Rios, Samuel
2 2:19,88  7
MAYOR
 16
Olivos, Lucas
3 2:20,35  6
WFE
 15
Bratz, Octavio
4 2:23,03  5
OHIGG
 16
Negrete, Arturo
5 2:24,64  4
CHIC-ZZ
 15
Bobadilla, Patricio
6 2:25,65  3
MAYOR
 15
Urtubia, Jorge
7 2:26,82  2
MAKO
 15
Aguirre, Matias
8 2:26,86  1
 Evento 70  Hombres 15-16 200 CL Metro CI
   Equipo	Nombre Tiempo de Finales
ATAL
 15
Martinez, Diego
1 2:19,41q
MAYOR
 16
Olivos, Lucas
2 2:19,74q
SF
 15
Medina Rios, Samuel
3 2:23,40q
WFE
 15
Bratz, Octavio
4 2:24,42q
OHIGG
 16
Negrete, Arturo
5 2:26,73q
MAYOR
 15
Urtubia, Jorge
6 2:26,93q
CHIC-ZZ
 15
Bobadilla, Patricio
7 2:27,94q
MAKO
 15
Aguirre, Matias
8 2:28,43q
MAYOR
 15
Aranguiz, Lucas
9 2:29,22
MAYOR
 16
Olivos, Joaquin
10 2:29,27
WFE
 15
Martinez, Vicente
11 2:29,48
SF
 16
Moreno Sahlie, Ignacio
12 2:32,17
CDUC
 15
Dominguez, Enrique
13 2:32,24
EE
 16
Fernandez, Vicente
14 2:34,05
ARENA
 15
Gutierrez, Nicolas
15 2:34,51
CDUC
 16
Ca áceres, Joaquin
16 2:35,97
APS
 15
Gonzalez Moreno, Diego Rodrigo
17 2:36,48
MAKO
 16
Flores, Gabriel
18 2:36,90
AMARU
 16
Zabala, Joaquin
19 2:37,90
MAKO
 15
Dinamarca, Matias
20 2:38,18
ARAU
 15
Carvajal, Luciano
21 2:40,86 ATAL
 16
Gonzalez Olivares, Thomas
22 2:41,48
MAKO
 16
Aravena, Martin
23 2:41,81
CDEP
 16
Vergara, Gabriel
24 2:43,87
COQUI
 16
Espinoza, Benjamin
25 2:45,35
MAKO
 15
Dinamarca, Diego
26 2:51,27
ATAL
 15
Izquierdo, Renato
27 2:53,56
ARAU
 15
Araya, Pablo
--- DQ	
 Evento 71  Hombres 17-99 200 CL Metro CI
   Equipo	Nombre	Tiempo de Finales	
SI
 20
Ahumada, Maximiliano
1 2:12,08  9
SI
 23
Quiroz, Felipe
2 2:18,00  7
HUMAN
 21
Torres, Giovanni
3 2:19,48  6
ATAL
 20
Furtado, Agustin
4 2:20,75  5
SF
 18
Pin ñerua Cuevas, Carlos
5 2:22,25  4
UNIDO
 19
Letelier, Tomas P
6 2:24,21  3
ATAL
 24
Prem, Juan Rodolfo
7 2:27,75  2
UNIDO
 17
Gil Buitrago, Antonio
--- DQ
 Evento 71  Hombres 17-99 200 CL Metro CI
   Equipo	Nombre Tiempo de Finales
SI
 23
Quiroz, Felipe
1 2:19,93q
SI
 20
Ahumada, Maximiliano
2 2:20,23q
HUMAN
 21
Torres, Giovanni
3 2:22,75q
UNIDO
 19
Letelier, Tomas P
4 2:24,85q
SF
 18
Pin ñerua Cuevas, Carlos
5 2:26,20q
UNIDO
 17
Gil Buitrago, Antonio
6 2:27,88q
ATAL
 24
Prem, Juan Rodolfo
7 2:28,48q
ATAL
 20
Furtado, Agustin
8 2:29,01q
HUMAN
 20
Bate, Thomas
9 2:29,86
ARAU
 17
Martinez, Eduardo
10 2:30,37
SEREN
 17
Saez, Matias
11 2:32,59
ARSU
 17
Lara, Kevin
*12 2:33,25
ATAL
 19
Iban ñez, Benjamin
*12 2:33,25
ARSU
 22
Diaz, Andres
14 2:34,63
MORRO
 17
Riquelme, Duam
15 2:39,72
TMF
 20
Acevedo, Juan Pablo
16 2:40,30
CDEP
 17
Zagal, Jalil
17 2:43,27
ATAL
 22
Chavez Hidalgo, Lukas
18 2:43,67
TMF
 19
Ceron, Jean Franco
19 2:45,18
ATAL
 20
Escobar, Vicente
20 2:47,68	
 Evento 72  Mujeres 13-14 200 CL Metro Estilo de Mariposa
   Equipo	Nombre	Tiempo de Finales	
SI
 14
Reyes, Fernanda
1 2:29,75  9
ATAL
 13	
Concha Marquez, Florencia Paz
2 2:35,03  7
WFE
 14
Klenner, Evaluna
3 2:37,40  6
MAYOR
 14
Ardiles, Trinidad
4 2:38,92  5
MAGAL
 14
Andersen, Sophia
5 2:42,94  4
CDEP
 13
Mun ñoz Barrios, Emilia
6 2:42,96  3
UNIDO
 13
Figueroa, Amanda
7 2:43,15  2
MAGAL
 14
Ortega, Constanza
8 2:46,21  1

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 26
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
 Evento 72  Mujeres 13-14 200 CL Metro Estilo de Mariposa    Equipo	Nombre Tiempo de Finales
MAYOR
 14
Ardiles, Trinidad
1 2:34,80q
SI
 14
Reyes, Fernanda
2 2:36,84q
ATAL
 13
Concha Marquez, Florencia Paz
3 2:37,36q
WFE
 14
Klenner, Evaluna
4 2:42,14q
UNIDO
 13
Figueroa, Amanda
5 2:43,63q
CDEP
 13
Mun ñoz Barrios, Emilia
6 2:44,44q
MAGAL
 14
Andersen, Sophia
7 2:45,07q
MAGAL
 14
Ortega, Constanza
8 2:45,38q
ARENA
 13
Ampuero, Martina
9 2:55,99
WFE
 13
Bratz, Josefa
10 2:59,43
MAKO
 13
Yan ñez, Catalina
11 3:08,53
ATAL
 14
Castro Gonzalez, Antonia
12 3:12,10
MAYOR
 13
Solis, Paulina
--- DQ
CDUC
 14
Pacheco, Matilda
--- DQ	
 Evento 73  Mujeres 15-16 200 CL Metro Estilo de Mariposa
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 16
Lewis, Diana
1 2:35,52  9
VIN ÑA
 15
Vallana, Javiera
2 2:39,15  7
ATAL
 15
Robles, Roberta
3 2:44,27  6
VITAC
 15
Kremer, Constanza
4 2:46,00  5
CDEP
 15
Smith, Catalina
5 2:47,32  4
WFE
 15
Martorel, Micaela
6 2:51,77  3
SI
 15
Barrenechea, Krasna
7 2:52,22  2
SI
 16
Zamora, Alicia
8 2:53,10  1
MAYOR
 15
Matsubara, Key
9 3:02,00
ARENA
 15
Gajardo, Martina
10 3:06,11
 Evento 73  Mujeres 15-16 200 CL Metro Estilo de Mariposa
   Equipo	Nombre Tiempo de Finales
ATAL
 15
Robles, Roberta
1 2:29,59q
VITAC
 15
Kremer, Constanza
2 2:32,14q
MAYOR
 16
Lewis, Diana
3 2:32,67q
VIN ÑA
 15
Vallana, Javiera
4 2:36,14q
CDEP
 15
Smith, Catalina
5 2:45,03q
SI
 16
Zamora, Alicia
6 2:48,52q
WFE
 15
Martorel, Micaela
7 2:49,57q
ARENA
 15
Gajardo, Martina
8 2:50,06q
SI
 15
Barrenechea, Krasna
9 2:50,09q
MAYOR
 15
Matsubara, Key
10 2:50,78q	
 Evento 74  Mujeres 17-99 200 CL Metro Estilo de Mariposa
   Equipo	Nombre	Tiempo de Finales	
SI
 27
Perez, Paola
1 2:20,94  9
MAKO
 22
Jimenez, Margaret
2 2:36,54  7
MAKO
 24
Olivares, Carolina
3 2:39,86  6
MAYOR
 17
Poges, Valentina
4 2:43,71  5
EE
 17
Carren ño, Angela
5 2:48,31  4
MAKO
 22
Thoma, Kathi
6 2:51,72  3
ATAL
 17
Caceres, Catalina
7 3:03,96  2	
 Evento 74  Mujeres 17-99 200 CL Metro Estilo de Mariposa
   Equipo	Nombre Tiempo de Finales
SI
 27
Perez, Paola
1 2:21,35q
MAKO
 22
Jimenez, Margaret
2 2:33,15q
MAKO
 22
Thoma, Kathi
3 2:34,55q
EE
 17
Carren ño, Angela
4 2:38,99q
MAKO
 24
Olivares, Carolina
5 2:40,00q
MAYOR
 17
Poges, Valentina
6 2:40,79q
ATAL
 17
Caceres, Catalina
7 2:50,67q	
 Evento 75  Hombres 13-14 400 CL Metro Combinado Relevo
 	
Relevo	Equipo	Tiempo de Finales	
Finales A
MAYOR
1 4:18,60  18
1) Osorio, Manuel 14 2) Lazzerini, Mariano 14
3) Menendez, Jose 14 4) Barriga, Sebastian 13
A
SF
2 4:29,58  14
1) Marchesini Ayala, Alejandro 14 2) Mora Orellana, Gonzalo 14
3) Cisternas Gomez, Eduardo 13 4) Tapia Aguilera, Pedro 14
A
ATAL
3 4:29,73  12	
1) Campos Hormazabal, Benjamin 13	2) Parada, Benjamin 14
3) Pavez Hormazabal, Cristian 14 4) Sanchez, Sebastian 13
A
SI
4 4:29,83  10
1) Madariaga, Lucas 14 2) Marin, Santiago 13
3) Rau, Constantino 14 4) Montagna, Vicente 14
A
ARENA
5 4:46,52  8
1) Cubillos, Vicente 14 2) Castillo, Nicolas 14
3) Biscupovic, Nicolas 14 4) Henriquez, Martin 13
A
MAGAL
6 4:47,19  6
1) Salazar, Alonso 13 2) Berrios, Reinaldo 14
3) Green, Vicente 13 4) Jara, Cristobal 14
A
MAKO
7 4:48,33  4
1) Costas, Matias 13 2) Barra, Benjamin 13
3) Fernandez, Alonso 14 4) Andalaft, Ignacio 14
A
UNIDO
8 4:50,42  2
1) Gustin, Daniel 14 2) Lim, Sean 14
3) Schnapp, Rafael 13 4) Yanñez, Francisco 14	
 Evento 75  Hombres 13-14 400 CL Metro Combinado Relevo
 	
Relevo	Equipo Tiempo de Finales
A
MAYOR
1 4:23,77q
1) Osorio, Manuel 14 2) Lazzerini, Mariano 14
3) Menendez, Jose 14 4) Barriga, Sebastian 13
A
SI
2 4:34,66q
1) Madariaga, Lucas 14 2) Marin, Santiago 13
3) Rau, Constantino 14 4) Montagna, Vicente 14
A
SF
3 4:36,39q
1) Marchesini Ayala, Alejandro 14 2) Mora Orellana, Gonzalo 14
3) Cisternas Gomez, Eduardo 13 4) Tapia Aguilera, Pedro 14
A
ATAL
4 4:37,90q
1) Campos Hormazabal, Benjamin 13	2) Parada, Benjamin 14
3) Pavez Hormazabal, Cristian 14 4) Sanchez, Sebastian 13
A
ARENA
5 4:44,28q
1) Cubillos, Vicente 14 2) Castillo, Nicolas 14
3) Biscupovic, Nicolas 14 4) Henriquez, Martin 13

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 27
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
...   (Evento 75  Hombres 13-14 400 CL Metro Combinado Relevo)	
 Relevo	Equipo Tiempo de Finales
A
MAGAL
6 4:46,37q
1) Salazar, Alonso 13 2) Berrios, Reinaldo 14
3) Green, Vicente 13 4) Jara, Cristobal 14
A
MAKO
7 4:49,87q
1) Costas, Matias 13 2) Barra, Benjamin 13
3) Fernandez, Alonso 14 4) Andalaft, Ignacio 14
A
UNIDO
8 4:51,60q
1) Gustin, Daniel 14 2) Lim, Sean 14
3) Schnapp, Rafael 13 4) Yanñez, Francisco 14
A
AUTO
9 4:51,79
1) Murillo, Rodrigo 14 2) Gonzalez, Benjamin 13
3) Hewstone, Felipe 13 4) Galleguillos, Lorenzo 14
A
SSWIM
10 4:52,93
1) Annaratone, Daniel 14 2) Ramos, Santiago 14
3) Rojas, Joaquin 14 4) Pavez, Martíán 14
A
EE
11 4:55,39
1) Estevez, Simon 14 2) Salazar, Andoni 13
3) Wensioe, Martin 14 4) Bravo, Max 14
A
CDEP
12 5:14,71
1) Moreno Paffetti, Martin 13 2) Acevedo  Celedon, Matias 14
3) Valderrama, Lucas 14 4) Elgueta, Marco Antonio 14
A
CDUC
13 5:17,27
1) Urrutia, Matias 14 2) Dufflocq, Julio 14
3) Palma, Pablo 14 4) Pedemonte, Facundo 13
A
SEREN
14 5:17,84
1) Saez, Alex 13 2) Torres, Ismael 13
3) Sepulveda, Vicente 14 4) Vega, Cristobal 13	
 Evento 76  Hombres 15-16 400 CL Metro Combinado Relevo
 	
Relevo	Equipo	Tiempo de Finales	
Finales A
MAYOR
1 4:17,79  18
1) Urtubia, Jorge 15 2) Olivos, Joaquin 16
3) Olivos, Lucas 16 4) Reyes, Benjamin 15
A
SF
2 4:24,06  14
1) Medina Rios, Samuel 15 2) Moreno Sahlie, Ignacio 16
3) Bastias Barra, Cristobal 16 4) Ortiz Munñoz, Vicente 16
A
WFE
3 4:24,16  12
1) Martinez, Vicente 15 2) Bratz, Octavio 15
3) Conus, Sergio 15 4) Lerzundi, Sebastian 15
A
ATAL
4 4:28,72  10
1) Barros Palma, Benjamin 15 2) Martinez, Diego 15
3) Gonzalez Olivares, Thomas 16 4) Mena, Santiago 16
A
UNIDO
5 4:33,65  8
1) Bravo, Benjamin 16 2) De la Vega, Rafael 15
3) Schnapp, Benjamin 16 4) Querales, Marcos 15
A
MAKO
6 4:40,80  6
1) Aguirre, Matias 15 2) Dinamarca, Matias 15
3) Flores, Gabriel 16 4) Aravena, Martin 16
A
CDEP
7 4:43,82  4
1) Medina, Sergio 15 2) Martinez, Sebastian 16
3) Toledo, Luis 15 4) Vergara, Gabriel 16
A
CDUC
--- DQ
1) Luttges, Arturo 16 2) Caáceres, Joaquin 16
3) Dominguez, Enrique 15 4) Romero, Diego 16	
 Evento 76  Hombres 15-16 400 CL Metro Combinado Relevo
 	
Relevo	Equipo Tiempo de Finales
A
MAYOR
1 4:07,00q
1) Urtubia, Jorge 15 2) Olivos, Joaquin 16
3) Olivos, Lucas 16 4) Reyes, Benjamin 15
A
ATAL
2 4:23,00q
1) Barros Palma, Benjamin 15 2) Martinez, Diego 15
3) Gonzalez Olivares, Thomas 16 4) Mena, Santiago 16
A
UNIDO
3 4:25,00q
1) Bravo, Benjamin 16 2) De la Vega, Rafael 15
3) Schnapp, Benjamin 16 4) Querales, Marcos 15
A
MAKO
4 4:30,00q
1) Aguirre, Matias 15 2) Dinamarca, Matias 15
3) Flores, Gabriel 16 4) Aravena, Martin 16
A
SF
5 4:32,01q
1) Medina Rios, Samuel 15 2) Moreno Sahlie, Ignacio 16
3) Bastias Barra, Cristobal 16 4) Ortiz Munñoz, Vicente 16
A
CDEP
6 4:35,00q
1) Medina, Sergio 15 2) Martinez, Sebastian 16
3) Toledo, Luis 15 4) Vergara, Gabriel 16
A
WFE
7 4:37,00q
1) Martinez, Vicente 15 2) Orizola, Sebastian 15
3) Conus, Sergio 15 4) Lerzundi, Sebastian 15
A
CDUC
8 4:45,00q
1) Luttges, Arturo 16 2) Caáceres, Joaquin 16
3) Dominguez, Enrique 15 4) Romero, Diego 16	
 Evento 76  Hombres 17-99 400 CL Metro Combinado Relevo
 	
Relevo	Equipo	Tiempo de Finales	
Finales A
EE
1 4:00,80  18
1) Quiroga, Augusto 17 2) Ortego, Ignacio 17
3) Cruz, Emilio 19 4) Varas, Carlos 26
A
MAYOR
2 4:03,30  14
1) Aracena, Yamil 17 2) Alvarez, Ignacio 17
3) Sepulveda, Joaquin 23 4) Araya, Gabriel 18
A
UNIDO
3 4:05,96  12
1) Bustamante, Hugo 18 2) Gil Buitrago, Antonio 17
3) Quintanilla, Benjamin 21 4) Ragazzone, Clemente 18
A
SI
4 4:08,35  10
1) Ahumada, Maximiliano 20 2) Quiroz, Felipe 23
3) Isla, Alejandro 27 4) Molina, Diego 21
A
SF
5 4:08,48  8
1) Perdomo Almiro án, Jose á 19 2) Pinñerua Cuevas, Carlos 18
3) Navarrete Arenas, Tomas 19 4) Perey Fica, Javier 24
A
ATAL
6 4:17,14  6
1) Prem, Juan Rodolfo 24 2) Furtado, Agustin 20
3) Korzeniowski, Facundo 19 4) Ibanñez, Benjamin 19
A
HUMAN
7 4:17,34  4
1) Bate, Thomas 20 2) Reyes, Claudio 21
3) Torres, Giovanni 21 4) Romo, Pablo 24
 Evento 76  Hombres 17-99 400 CL Metro Combinado Relevo
 	
Relevo	Equipo Tiempo de Finales
A
MAYOR
1 3:56,00q
1) Aracena, Yamil 17 2) Alvarez, Ignacio 17
3) Sepulveda, Joaquin 23 4) Araya, Gabriel 18

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 28
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
...   (Evento 76  Hombres 17-99 400 CL Metro Combinado Relevo)	
 Relevo	Equipo Tiempo de Finales
A
EE
2 4:02,00q
1) Quiroga, Augusto 17 2) Ortego, Ignacio 17
3) Cruz, Emilio 19 4) Varas, Carlos 26
A
UNIDO
3 4:04,14q
1) Bustamante, Hugo 18 2) Gil Buitrago, Antonio 17
3) Quintanilla, Benjamin 21 4) Ragazzone, Clemente 18
A
SF
4 4:05,01q
1) Perdomo Almiro án, Jose á 19 2) Pinñerua Cuevas, Carlos 18
3) Navarrete Arenas, Tomas 19 4) Perey Fica, Javier 24
A
ATAL
5 4:14,00q
1) Prem, Juan Rodolfo 24 2) Furtado, Agustin 20
3) Korzeniowski, Facundo 19 4) Ibanñez, Benjamin 19
A
SI
6 4:25,00q
1) Ahumada, Maximiliano 20 2) Quiroz, Felipe 23
3) Isla, Alejandro 27 4) Molina, Diego 21
A
HUMAN
7 4:40,00q
1) Bate, Thomas 20 2) Reyes, Claudio 21
3) Torres, Giovanni 21 4) Romo, Pablo 24	
 Evento 77  Mujeres 13-14 400 CL Metro Estilo Libre Relevo
 	
Relevo	Equipo	Tiempo de Finales	
Finales A
SSWIM
1 4:21,97  18
1) Castro, Daniela 13 2) Gonzaález, Fernanda 14
3) Moyano, Josefina 13 4) Díáaz, Millaray 13
A
MAYOR
2 4:23,68  14
1) Ardiles, Trinidad 14 2) Solis, Paulina 13
3) Gonzales, Magdalena 13 4) Cubillos, Antonia 14
A
SI
3 4:24,92  12
1) Ramirez, Pia 14 2) Cepeda, Maria Jesus 13
3) Barrenechea, Alemka 13 4) Reyes, Fernanda 14
A
ATAL
4 4:31,06  10
1) Asenjo, Renata 13 2) Castro Gonzalez, Antonia 14
3) Carrasco, Consuelo 13	
4) Concha Marquez, Florencia Paz 13
A
UNIDO
5 4:34,39  8
1) Custodio, Bruna 14 2) Reginato, Maria Belen 13
3) Gonzalez, Victoria 14 4) Bunce, Kennedy 13
A
ARENA
6 4:43,42  6
1) Molina, Natalia 13 2) Farmer, Holly 13
3) Ampuero, Martina 13 4) Perez, Francisca 14
A
SF
7 4:45,40  4
1) Pizarro Brito, Isidora 13 2) Jara Gallegos, Sofia 13
3) Bruno Colmenares, Camila 14 4) Torres Reina, Brianna 13
A
MAGAL
8 4:46,28  2
1) Ortega, Constanza 14 2) Valdes, Isis 13
3) Cabello, Giuliana 13 4) Andersen, Sophia 14
A
CDEP
9 4:46,42
1) Anabalon, Sofia 13 2) Munñoz Barrios, Emilia 13
3) Solano, Sofia 14 4) Bustos, Renata Paz 14	
 Evento 77  Mujeres 13-14 400 CL Metro Estilo Libre Relevo
 	
Relevo	Equipo Tiempo de Finales
A
UNIDO
*1 4:20,00q
1) Custodio, Bruna 14 2) Reginato, Maria Belen 13
3) Gonzalez, Victoria 14 4) Bunce, Kennedy 13 A
SSWIM
*1 4:20,00q
1) Castro, Daniela 13 2) Gonzaález, Fernanda 14
3) Moyano, Josefina 13 4) Díáaz, Millaray 13
A
SI
3 4:25,00q
1) Reyes, Fernanda 14 2) Ramirez, Pia 14
3) Cepeda, Maria Jesus 13 4) Barrenechea, Alemka 13
A
MAYOR
*4 4:30,00q
1) Ardiles, Trinidad 14 2) Cancino, Paz 13
3) Gonzales, Magdalena 13 4) Cubillos, Antonia 14
A
ATAL
*4 4:30,00q
1) Asenjo, Renata 13 2) Castro Gonzalez, Antonia 14
3) Carrasco, Consuelo 13	
4) Concha Marquez, Florencia Paz 13
A
MAGAL
7 4:37,00q
1) Mun ñoz, Skarlet 14 2) Ortega, Constanza 14
3) Valdes, Isis 13 4) Andersen, Sophia 14
A
ARENA
8 4:42,00q
1) Molina, Natalia 13 2) Farmer, Holly 13
3) Ampuero, Martina 13 4) Perez, Francisca 14
A
CDEP
9 4:43,34q
1) Anabalon, Sofia 13 2) Munñoz Barrios, Emilia 13
3) Solano, Sofia 14 4) Bustos, Renata Paz 14
A
SF
10 4:44,01
1) Pizarro Brito, Isidora 13 2) Jara Gallegos, Sofia 13
3) Bruno Colmenares, Camila 14 4) Torres Reina, Brianna 13	
 Evento 78  Mujeres 15-16 400 CL Metro Estilo Libre Relevo
 	
Relevo	Equipo	Tiempo de Finales	
Finales A
VIN ÑA
1 4:14,52  18
1) Contreras, Gabriela 15 2) Arredondo, Alexandra 15
3) Araya, Sofia 15 4) Vallana, Javiera 15
A
MAYOR
2 4:15,59  14
1) Bustamante, Catalina 16 2) Matsubara, Key 15
3) Saldes, Paloma 16 4) Lewis, Diana 16
A
SI
3 4:30,78  12
1) Collingwoord, Camila 16 2) Barrenechea, Krasna 15
3) Gomez, Renata 15 4) Zamora, Alicia 16
A
CDEP
4 4:46,70  10
1) Llunell Vilte, Janett 15 2) Smith, Catalina 15
3) Balderas, Tania 15 4) Munñoz, Matilde 16
 Evento 78  Mujeres 15-16 400 CL Metro Estilo Libre Relevo
 	
Relevo	Equipo Tiempo de Finales
A
MAYOR
1 4:14,00q
1) Palomino, Naiomi 15 2) Valdes, Javiera 16
3) Saldes, Paloma 16 4) Bustamante, Catalina 16
A
SI
3 4:30,00q
1) Zamora, Alicia 16 2) Collingwoord, Camila 16
3) Gomez, Renata 15 4) Barrenechea, Krasna 15
A
VIN ÑA
4 4:30,01q
1) Contreras, Gabriela 15 2) Arredondo, Alexandra 15
3) Araya, Sofia 15 4) Vallana, Javiera 15
A
CDEP
5 4:36,93q
1) Llunell Vilte, Janett 15 2) Smith, Catalina 15
3) Balderas, Tania 15 4) Munñoz, Matilde 16

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 29
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
 Evento 78  Mujeres 17-99 400 CL Metro Estilo Libre Relevo  	
Relevo	Equipo	Tiempo de Finales	
Finales A
SI
1 4:18,27  18
1) Valdivia, Mahina 22 2) Perez, Paola 27
3) Aguilar, Catalina 22 4) Quiroz, Bahia 24
A
MAKO
2 4:24,86  14
1) Thoma, Kathi 22 2) Ramirez, Maria Victoria 19
3) Olivares, Carolina 24 4) Jimenez, Margaret 22
A
ATAL
3 4:28,25  12
1) Caceres, Catalina 17 2) Rebolledo, M. Fernanda 17	
3) Campos Hormazabal, Trinidad 17	4) Fuenzalida, Valentina 17
A
OHIGG
4 4:29,58  10
1) Pen ñailillo Alfonso, Isidora 17 2) Escobar Molina, Sara 19
3) Droguett M, Sofia 18
4) Pen ñailillo Alfonso, Anita Cristina 19
A
MAYOR
5 4:32,91  8
1) Poges, Valentina 17 2) Castillo, Emilia 25
3) Cea, Francisca 19 4) Crisostomo, Maira 17	
 Evento 78  Mujeres 17-99 400 CL Metro Estilo Libre Relevo
 	
Relevo	Equipo Tiempo de Finales
A
ATAL
1 4:20,00q
1) Caceres, Catalina 17 2) Rebolledo, M. Fernanda 17
3) Campos Hormazabal, Trinidad 17	4) Fuenzalida, Valentina 17
A
MAKO
*2 4:25,00q
1) Thoma, Kathi 22 2) Ramirez, Maria Victoria 19
3) Olivares, Carolina 24 4) Jimenez, Margaret 22
A
SI
*2 4:25,00q
1) Valdivia, Mahina 22 2) Perez, Paola 27
3) Aguilar, Catalina 22 4) Quiroz, Bahia 24
A
OHIGG
4 4:28,15q
1) Pen ñailillo Alfonso, Isidora 17 2) Escobar Molina, Sara 19
3) Droguett M, Sofia 18
4) Pen ñailillo Alfonso, Anita Cristina 19
A
MAYOR
5 4:30,00q
1) Poges, Valentina 17 2) Castillo, Emilia 25
3) Cea, Francisca 19 4) Crisostomo, Maira 17	
 Evento 79  Mujeres 13-14 50 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
WFE
 14
Klenner, Evaluna
1 29,35  9
SF
 13
Pizarro Brito, Isidora
*2 29,63  6,5
AERO
 14
Rojas, Catalina
*2 29,63  6,5
HUMAN
 14
Orellana, Sofia
4 29,64  5
N ÑIELO
 13
Iturriaga, Soraya
5 29,76  4
MAYOR
 14
Cubillos, Antonia
6 29,78  3
SI
 14
Ramirez, Pia
7 29,86  2
VICEN
 14
Quinteros, Elizabeth
8 29,90  1
 Evento 79  Mujeres 13-14 50 CL Metro Estilo Libre
   Equipo	Nombre Tiempo de Finales
SF
 13
Pizarro Brito, Isidora
1 29,85q
HUMAN
 14
Orellana, Sofia
2 29,90q
WFE
 14
Klenner, Evaluna
3 29,97q
N ÑIELO
 13
Iturriaga, Soraya
4 29,99q
MAYOR
 14
Cubillos, Antonia
5 30,00q AERO
 14
Rojas, Catalina
6 30,12q
VICEN
 14
Quinteros, Elizabeth
7 30,26q
SI
 14
Ramirez, Pia
8 30,54q
SSWIM
 13
Díáaz, Millaray
9 30,59
UNIDO
 13
Bunce, Kennedy
10 30,67
UNIDO
 14
Custodio, Bruna
11 30,71
VIN ÑA
 13
Araya, Florecnia
12 30,88
APS
 13	
Ortiz Herna ández, Barbara Aracely
13 31,24
TEMUC
 13
Aliste, Josefina
14 31,30
WFE
 14
Llaupe, Janka
15 31,31
EE
 14
Bennewitz, Catalina
16 31,38
MAYOR
 13
Gonzales, Magdalena
17 31,40
ARSU
 14
Pulgar, Antonia
18 31,62
CDUC
 13	
Delgado Noches, Isidora Antonia
19 31,63
ARENA
 13
Ampuero, Martina
20 31,76
CDEP
 14
Bustos, Renata Paz
21 31,80
ARENA
 13
Farmer, Holly
22 31,91
MAYOR
 13
Reyes, Fernanda
23 31,93
WFE
 13
Bratz, Josefa
24 32,07
AUTO
 13
Cordova, Josefina
25 32,13
ATAL
 13
Asenjo, Renata
26 32,17
SI
 13
Cepeda, Maria Jesus
27 32,18
LAUTA
 13
Mora, Alen
28 32,32
CDUC
 13
Venegas, Isidora
29 32,47
OHIGG
 14
Ramirez, Anais
30 32,54
MAGAL
 14
Mun ñoz, Skarlet
31 32,55
VICEN
 14
Ahumada, Fernanda
32 32,60
AV
 13
Medina, Josefa
33 32,77
AERO
 14
Corte ás, Paz
*34 32,78
HUMAN
 14
Moraga, Scarlette
*34 32,78
SEREN
 13
Diaz, Antonia
36 32,82
UNIDO
 14
Gonzalez, Victoria
37 32,89
ARENA
 13
Molina, Natalia
38 33,00
VIN ÑA
 14
Lara, Valeria
39 33,11
ARENA
 14
Perez, Francisca
40 33,18
CDUC
 14
Pacheco, Renata
41 33,27
VICEN
 14
Gonzalez, Isidora
42 33,47
APS
 13	
Sepulveda Tapia, Valentina Sofíáa
43 33,63
MAGAL
 13
Romero, Francisca
44 33,78
OHIGG
 13
Perromat Villacura, Martina
45 33,80
VICEN
 13
Hansen, Anke
46 34,02
HUMAN
 13
Gonzalez, Catalina
47 34,41
OHIGG
 14
Leiva Polanco, Sofia
48 34,86
MAGAL
 13
Cabello, Giuliana
49 34,87
CDEP
 13
Mun ñoz Barrios, Emilia
50 34,98
N ÑIELO
 13
Carrasco, Laura
51 35,00
ATAL
 14
Moya Henriquez, Antonia
52 35,25
VICEN
 13
Hansen, Andra
53 35,33
HUMAN
 13
Diaz, Catalina
54 35,35
AMARU
 14
Armijo, Almendra
55 35,58
UNIDO
 13
Figueroa, Amanda
56 35,65
SI
 13
Lagos, Rocio
57 36,10
SEREN
 14
Ampuero, Daniela
58 37,15
MAKO
 13
Ortubia, Gabriela
59 38,15

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 30
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
 Evento 80  Mujeres 15-16 50 CL Metro Estilo Libre    Equipo	Nombre	Tiempo de Finales	
EE
 16
Marin, Ines
1 27,21  9
VIN ÑA
 15
Contreras, Gabriela
2 28,52  7
SI
 16
Zamora, Alicia
3 29,16  6
VIN ÑA
 15
Araya, Sofia
4 29,26  5
MAYOR
 16
Saldes, Paloma
5 29,74  4
ATAL
 16
Zamora Torres, Laura
6 29,94  3
CDEP
 15
Llunell Vilte, Janett
7 30,35  2
CDUC
 15
Stein, Valentina
8 31,01  1
 Evento 80  Mujeres 15-16 50 CL Metro Estilo Libre
   Equipo	Nombre Tiempo de Finales
EE
 16
Marin, Ines
1 27,97q
SI
 16
Zamora, Alicia
2 29,43q
VIN ÑA
 15
Contreras, Gabriela
3 29,50q
ATAL
 16
Zamora Torres, Laura
4 30,05q
VIN ÑA
 15
Araya, Sofia
5 30,06q
CDEP
 15
Llunell Vilte, Janett
6 30,45q
MAYOR
 16
Saldes, Paloma
7 30,74q
CDUC
 15
Stein, Valentina
8 30,87q
SEREN
 15
Carrion, Luna
9 30,89
MORRO
 15
Ojeda, Damari
10 31,21
AV
 15
Medina Solis, Jazmin
11 31,31
EE
 16
Brito, Carolina
12 31,43
ARAU
 15
Mendez, Martina
13 31,52
MAGAL
 16
Gamboa, Kamila
14 31,66
ARSU
 16
Seyssel, Pamela
15 31,69
AV
 16
Gomez Fett, Paulina
16 32,04
CDEP
 15
Zavala, Aranzazu
17 32,05
VIN ÑA
 15
Godoy, Kiara
18 32,10
EE
 15
Quiroga, Renata
*19 32,11
CDEP
 15
Smith, Catalina
*19 32,11
MAYOR
 16
Valdes, Fernanda
21 32,15
MAYOR
 16
Valenzuela, Daniella
22 32,46
ARSU
 15
Contreras, Maria Jose
23 32,97
OHIGG
 15
Flores, Paz
24 33,03
CDUC
 15
Pen ña, Beatriz
25 33,64
TMF
 15
Garrido, Cecilia
26 33,67
COQUI
 16
Rojas, Carolina
27 33,89
SEREN
 15
Sanchez, Valentina
28 34,32
ARENA
 16
Reyes, Aranza
29 35,67
VICEN
 15
Rojo, Macarena
30 35,86
TEMUC
 15
Melinao, Constanza
31 35,99
VICEN
 16
Thiele, Magdalena
32 36,00	
 Evento 81  Mujeres 17-99 50 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
EE
 17
Carren ño, Angela
1 28,99  9
MAYOR
 17
Poges, Valentina
2 29,16  7
ATAL
 17	
Campos Hormazabal, Trinidad
3 29,31  6
MAKO
 22
Thoma, Kathi
4 29,35  5
SSWIM
 23
Chanuar, Leila
5 29,36  4
CDEP
 17
Cardona, Valeria
6 29,38  3
SI
 22
Aguilar, Catalina
7 29,65  2
VITAC
 19
Videla, Valeria
8 29,77  1	
 Evento 81  Mujeres 17-99 50 CL Metro Estilo Libre
   Equipo	Nombre Tiempo de Finales
MAYOR
 17
Poges, Valentina
1 28,85q
MAKO
 22
Thoma, Kathi
2 29,05q
VITAC
 19
Videla, Valeria
3 29,31q
SSWIM
 23
Chanuar, Leila
4 29,46q
CDEP
 17
Cardona, Valeria
5 29,59q
ATAL
 17
Campos Hormazabal, Trinidad
6 29,68q
EE
 17
Carren ño, Angela
7 29,72q
SI
 22
Aguilar, Catalina
8 29,74q
UNIDO
 17
Mauriziano, Chiara
9 29,86
MAYOR
 19
Cea, Francisca
10 29,98
HUMAN
 23
Bazaez, Valeria
11 30,40
CDEP
 17	
Hernandez Mun ñoz, Constanza
12 30,42
OHIGG
 17
Pen ñailillo Alfonso, Isidora
13 30,47
UNIDO
 20
Morales, Barbara
14 30,48
SEREN
 18
Torres, Pamela
15 30,61
APS
 18
Bru üning Belmar, Maríáa Jose á
16 30,83
OHIGG
 19
Escobar Molina, Sara
17 31,06
MAKO
 24
Olivares, Carolina
18 31,16
AUTO
 18
Zepeda, Victoria
19 31,36
ATAL
 20
Gutierrez, Savka
20 31,42
ARSU
 17
Lopez, Rocio
21 31,45
OHIGG
 18
Droguett M, Sofia
22 31,51
ATAL
 17
Rebolledo, M. Fernanda
23 31,82
MAKO
 19
Ramirez, Maria Victoria
24 32,22
MAYOR
 25
Castillo, Emilia
25 32,35
VIN ÑA
 17
Gonzalez, Maylin
26 32,43
ATAL
 23
Bravo, Claudia
27 32,50
MORRO
 19
Rojas, Daniella
28 32,69
CDUC
 25
Chamorro, Alejandra
29 32,73
VIN ÑA
 21
Toledo, Paulina
30 32,79
AERO
 17
Ulloa, Bele án
31 33,19
HUMAN
 19
Aliste, Camila
32 33,25
CHIC-ZZ
 17
Fernandez, Constanza
33 34,25
MORRO
 20
Rojas, Romina
34 36,25
 Evento 82  Hombres 13-14 50 CL Metro Estilo de Espalda
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 14
Osorio, Manuel
1 28,09  9
SF
 14
Marchesini Ayala, Alejandro
2 29,21  7
CHIC-ZZ
 14
Munoz, Benjamin
3 29,68  6
EE
 14
Estevez, Simon
4 31,68  5
UNIDO
 13
Schnapp, Rafael
5 31,70  4
UNIDO
 14
Gustin, Daniel
6 31,72  3
MAKO
 13
Pen ña, Martin
7 32,84  2
AUTO
 14
Murillo, Rodrigo
8 33,60  1

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 31
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
 Evento 82  Hombres 13-14 50 CL Metro Estilo de Espalda    Equipo	Nombre Tiempo de Finales
MAYOR
 14
Osorio, Manuel
1 28,48q
CHIC-ZZ
 14
Munoz, Benjamin
2 29,92q
SF
 14
Marchesini Ayala, Alejandro
3 30,37q
EE
 14
Estevez, Simon
4 31,34q
UNIDO
 13
Schnapp, Rafael
5 31,73q
UNIDO
 14
Gustin, Daniel
6 31,97q
MAKO
 13
Pen ña, Martin
7 33,13q
AUTO
 14
Murillo, Rodrigo
8 33,35q
MAKO
 13
Costas, Matias
9 34,05
SSWIM
 14
Annaratone, Daniel
10 34,55
MAKO
 14
Andalaft, Ignacio
11 34,61
ARAU
 14
Olivares, Gabriel
12 35,08
CDEP
 13
Moreno Paffetti, Martin
13 35,19
ARENA
 13
Gatica, Leonardo
14 35,43
MAGAL
 13
Salazar, Alonso
15 35,45
ARSU
 13
Caro, Ma áximo
16 35,54
TMF
 13
Urutia, Edgar
17 37,24
ATAL
 14
Esteves, Emilio
18 37,85
SEREN
 13
Saez, Alex
19 38,75
APS
 14
Romero Brizuen ño, Juan Pablo Sebastian
20 39,03
HUMAN
 13
Duarte, Felipe
21 39,22
CDUC
 13
Pedemonte, Facundo
22 39,60
MAKO
 13
Carrasco, Martin
23 41,42
 Evento 83  Hombres 15-16 50 CL Metro Estilo de Espalda
   Equipo	Nombre	Tiempo de Finales	
HUMAN
 16
Torres, Maximiliano
1 29,26  9
MAYOR
 15
Reyes, Benjamin
2 29,64  7
WFE
 15
Lerzundi, Sebastian
3 29,69  6
OHIGG
 16
Negrete, Arturo
4 30,32  5
MAYOR
 15
Urtubia, Jorge
5 30,59  4
ARAU
 15
Araya, Pablo
6 31,36  3
WFE
 15
Orizola, Sebastian
7 31,39  2
COQUI
 16
Espinoza, Benjamin
8 32,76  1
 Evento 83  Hombres 15-16 50 CL Metro Estilo de Espalda
   Equipo	Nombre Tiempo de Finales
HUMAN
 16
Torres, Maximiliano
1 29,64q
MAYOR
 15
Reyes, Benjamin
2 29,77q
WFE
 15
Lerzundi, Sebastian
3 30,32q
OHIGG
 16
Negrete, Arturo
4 30,52q
MAYOR
 15
Urtubia, Jorge
5 30,93q
ARAU
 15
Araya, Pablo
6 31,57q
WFE
 15
Orizola, Sebastian
7 32,34q
COQUI
 16
Espinoza, Benjamin
8 32,62q
ATAL
 16
Mena, Santiago
9 32,77
AMARU
 16
Zabala, Joaquin
10 33,07
MAGAL
 15
Alvarado, Matias
11 33,11
ATAL
 15
Barros Palma, Benjamin
12 33,12
CDUC
 16
Ca áceres, Joaquin
13 33,56
TMF
 16
Arias, Francisco
14 33,77 EE
 16
Fernandez, Vicente
15 33,81
CDUC
 15
Dominguez, Enrique
16 33,96
MAKO
 15
Dinamarca, Diego
17 35,35
AUTO
 16
Barrera, Juan
18 35,48
CDUC
 16
Luttges, Arturo
19 35,74
CDUC
 16
Romero, Diego
20 36,21
MAGAL
 15
Valenzuela, Joaquin
21 41,39
SF
 15
Medina Rios, Samuel
--- DQ
MAYOR
 15
Guajardo, Jose
--- DQ	
 Evento 84  Hombres 17-99 50 CL Metro Estilo de Espalda
   Equipo	Nombre	Tiempo de Finales	
SI
 20
Ahumada, Maximiliano
1 27,67  9
UNIDO
 21
Quintanilla, Benjamin
2 28,02  7
VIN ÑA
 17
Araya, Vicente
3 28,15  6
MAYOR
 17
Cea, Arturo
4 28,17  5
UNIDO
 18
Bustamante, Hugo
5 28,37  4
EE
 17
Quiroga, Augusto
6 28,70  3
CDUC
 23
Saavedra, Diego
7 28,73  2
MAYOR
 17
Aracena, Yamil
8 28,94  1
 Evento 84  Hombres 17-99 50 CL Metro Estilo de Espalda
   Equipo	Nombre Tiempo de Finales

VINÑA
 17
Araya, Vicente
1 28,17q
SI
 20
Ahumada, Maximiliano
2 28,30q
UNIDO
 21
Quintanilla, Benjamin
3 28,64q
MAYOR
 17
Cea, Arturo
4 28,83q
EE
 17
Quiroga, Augusto
5 28,85q
MAYOR
 17
Aracena, Yamil
6 29,02q
UNIDO
 18
Bustamante, Hugo
7 29,17q
CDUC
 23
Saavedra, Diego
8 29,27q
SI
 21
Molina, Diego
9 29,33
SF
 19
Perdomo Almiro án, Jose á
10 29,54
UNIDO
 19
Letelier, Tomas P
11 29,66
HUMAN
 20
Bate, Thomas
12 29,94
EE
 35
Peruga, Alberto
13 30,05
SI
 24
Borello, Xoan
14 30,15
EE
 26
Varas, Carlos
15 30,23
EE
 19
Cruz, Emilio
16 30,63
SEREN
 17
Saez, Matias
17 30,72
MAYOR
 18
Azocar, Matias
18 30,97
SF
 17
Chamorro Jara, Benjamin
19 31,01
ARSU
 17
Lara, Kevin
20 31,17
EE
 19
Fernandez, Max
21 31,32
MAKO
 17
Estay, Ignacio
22 31,41
SI
 27
Isla, Alejandro
23 31,58
EE
 19
Quintero, Felipe
24 32,12
MAKO
 22
Olea, David
25 32,49
AMARU
 17
Antiguay, Matias
26 32,56
ARSU
 17
Pulgar, Javier
27 33,01
VITAC
 19
Bertranou, Matias
28 35,04	
 Evento 85  Niñas 13-14 1500 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
UNIDO
 14
Custodio, Bruna
1 19:14,74  9
VITAC
 13
Alberti, Giuliana
2 20:05,74  7

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 32
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
(Evento 85  Niñas 13-14 1500 CL Metro Estilo Libre) 
   Equipo	Nombre	Tiempo de Finales	
APS
 14	Buzolic Moreno, Tonka Alejandra
3 20:16,40  6
SSWIM
 14
Gonza ález, Fernanda
4 21:05,69  5
ATAL
 13
Carrasco, Consuelo
5 22:00,86  4	
 Evento 85  Mujeres 15-16 1500 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 16
Bustamante, Catalina
1 18:40,40  9
VITAC
 15
Kremer, Constanza
2 19:22,69  7
UNIDO
 15
Mondaca, Vaithiare
3 20:32,88  6	
 Evento 85  Mujeres 17-99 1500 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
SI
 27
Perez, Paola
1 18:01,47  9
SI
 22
Valdivia, Mahina
2 18:18,32  7
ATAL
 17
Fuenzalida, Valentina
3 19:51,28  6
ATAL
 17
Caceres, Catalina
4 21:46,82  5	
 Evento 86  Hombres 13-14 200 CL Metro Estilo de Pecho
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 14
Lazzerini, Mariano
1 2:35,66  9
WFE
 14
Crhistopher, Conus
2 2:42,68  7
TEMUC
 14
Gesche, Diego
3 2:49,55  6
EE
 13
Salazar, Andoni
4 2:50,64  5
ARSU
 13
Gajardo, Juan Pablo
5 2:50,67  4
SI
 13
Marin, Santiago
6 2:51,43  3
APS
 13
Melin Del Valle, Reiner Alario
7 2:52,66  2
ARENA
 14
Cubillos, Vicente
8 2:58,78  1
 Evento 86  Hombres 13-14 200 CL Metro Estilo de Pecho
   Equipo	Nombre Tiempo de Finales

MAYOR
 14
Lazzerini, Mariano
1 2:40,92q
WFE
 14
Crhistopher, Conus
2 2:45,63q
TEMUC
 14
Gesche, Diego
3 2:48,53q
ARSU
 13
Gajardo, Juan Pablo
4 2:51,42q
ARENA
 14
Cubillos, Vicente
5 2:52,90q
EE
 13
Salazar, Andoni
6 2:53,35q
SI
 13
Marin, Santiago
7 2:53,53q
APS
 13
Melin Del Valle, Reiner Alario
8 2:53,82q
ATAL
 14
Parada, Benjamin
9 2:57,47
MAKO
 13
Barra, Benjamin
10 2:58,02
MAGAL
 14
Berrios, Reinaldo
11 2:58,72
ARENA
 14
Castillo, Nicolas
12 2:59,08
EE
 14
Bravo, Max
13 2:59,48
UNIDO
 14
Lim, Sean
14 3:01,17
CDUC
 14
Dufflocq, Julio
15 3:05,68
AUTO
 14
Galleguillos, Lorenzo
16 3:05,83
SI
 14
Oteiza, Antonio
17 3:07,05
MAKO
 13
Manordes, Lucas
18 3:07,08
MAKO
 14
Gallardo, Sebastian
19 3:07,20
MAYOR
 13
Barriga, Sebastian
20 3:08,06
CDEP
 14
Acevedo  Celedon, Matias
21 3:08,27
SI
 13
Rodriguez, Agustin
22 3:11,13
CDEP
 14
Valderrama, Lucas
23 3:14,20
SI
 13
Gergi, Christian
24 3:16,23 SF
 14
Mora Orellana, Gonzalo
25 3:17,40
COQUI
 14
Calfupan, Cristian
26 3:19,61
SEREN
 13
Torres, Ismael
27 3:26,83	
 Evento 87  Hombres 15-16 200 CL Metro Estilo de Pecho
   Equipo	Nombre	Tiempo de Finales	
AV
 16	
Hansen Tatter, Gerhart Nicholas
1 2:36,10  9
MAYOR
 16
Olivos, Joaquin
2 2:39,97  7
MAYOR
 15
Aranguiz, Lucas
3 2:45,35  6
SI
 15
De Ferrari, Constantino
4 2:46,29  5
ARENA
 15
Gutierrez, Nicolas
5 2:49,80  4
VIN ÑA
 16
Almonacid, Vicente
6 2:52,61  3
MAKO
 15
Aguirre, Matias
7 2:52,87  2
AUTO
 15
Zepeda, Agustin
8 2:57,71  1
SSWIM
 15
Castan ñon, Diego
9 2:58,37	
 Evento 87  Hombres 15-16 200 CL Metro Estilo de Pecho
   Equipo	Nombre Tiempo de Finales
AV
 16
Hansen Tatter, Gerhart Nicholas
1 2:29,00q
MAYOR
 16
Olivos, Joaquin
2 2:36,56q
MAYOR
 15
Aranguiz, Lucas
3 2:40,87q
MAKO
 15
Aguirre, Matias
4 2:43,00q
SI
 15
De Ferrari, Constantino
5 2:44,76q
MAKO
 15
Dinamarca, Matias
6 2:45,00q
AUTO
 15
Zepeda, Agustin
7 2:51,10q
SSWIM
 15
Castan ñon, Diego
8 2:51,60q
ARENA
 15
Gutierrez, Nicolas
9 2:52,00q
VIN ÑA
 16
Almonacid, Vicente
10 2:52,19q	
 Evento 88  Hombres 17-99 200 CL Metro Estilo de Pecho
   Equipo	Nombre	Tiempo de Finales	
ATAL
 20
Furtado, Agustin
1 2:31,42  9
EE
 17
Ortego, Ignacio
2 2:32,30  7
UNIDO
 17
Gil Buitrago, Antonio
3 2:32,63  6
SF
 18
Pin ñerua Cuevas, Carlos
4 2:36,36  5
SI
 23
Quiroz, Felipe
5 2:37,21  4
MAYOR
 17
Alvarez, Ignacio
6 2:38,25  3
HUMAN
 21
Reyes, Claudio
7 2:44,15  2
ARAU
 17
Martinez, Eduardo
8 2:49,68  1
 Evento 88  Hombres 17-99 200 CL Metro Estilo de Pecho

   Equipo	Nombre Tiempo de Finales
UNIDO
 17
Gil Buitrago, Antonio
1 2:35,82q
EE
 17
Ortego, Ignacio
2 2:37,61q
ATAL
 20
Furtado, Agustin
3 2:38,75q
MAYOR
 17
Alvarez, Ignacio
4 2:40,15q
SF
 18
Pin ñerua Cuevas, Carlos
5 2:40,17q
SI
 23
Quiroz, Felipe
6 2:42,63q
HUMAN
 21
Reyes, Claudio
7 2:44,26q
ARAU
 17
Martinez, Eduardo
8 2:49,85q
ATAL
 20
Escobar, Vicente
9 2:55,86
ARSU
 18
Gallardo, Joaquin
10 2:57,08
TMF
 20
Acevedo, Juan Pablo
11 3:02,56

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 33
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
 Evento 89  Mujeres 13-14 100 CL Metro Estilo de Espalda 
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 14
Ardiles, Trinidad
1 1:06,53  9
SF
 13
Pizarro Brito, Isidora
2 1:12,49  7
SSWIM
 13
Castro, Daniela
3 1:13,40  6
ATAL
 13	
Concha Marquez, Florencia Paz	4 1:13,79  5
CDEP
 13
Anabalon, Sofia
5 1:13,98  4
CDUC
 14
Pacheco, Matilda
6 1:14,39  3
WFE
 14
Llaupe, Janka
7 1:15,39  2
MAYOR
 13
Gonzales, Magdalena
8 1:17,29  1	
 Evento 89  Mujeres 13-14 100 CL Metro Estilo de Espalda
   Equipo	Nombre Tiempo de Finales
MAYOR
 14
Ardiles, Trinidad
1 1:06,79q
SF
 13
Pizarro Brito, Isidora
2 1:12,36q
CDUC
 14
Pacheco, Matilda
3 1:13,79q
ATAL
 13
Concha Marquez, Florencia Paz	4 1:13,87q
CDEP
 13
Anabalon, Sofia
5 1:15,11q
WFE
 14
Llaupe, Janka
6 1:15,32q
SSWIM
 13
Castro, Daniela
7 1:15,87q
MAYOR
 13
Gonzales, Magdalena
8 1:16,53q
CDEP
 14
Solano, Sofia
9 1:16,61
ARENA
 13
Farmer, Holly
10 1:18,25
MAYOR
 13
Cancino, Paz
11 1:18,86
VITAC
 13
Miranda, Jennifer
12 1:18,96
WFE
 13
Bratz, Josefa
13 1:19,99
SI
 13
Barrenechea, Alemka
14 1:20,83
APS
 14	
Buzolic Moreno, Tonka Alejandra
15 1:20,91
ATAL
 14
Castro Gonzalez, Antonia
16 1:21,37
VICEN
 14
Ahumada, Fernanda
17 1:21,45
AERO
 14
Rojas, Catalina
18 1:21,47
VICEN
 14
Quinteros, Elizabeth
19 1:21,68
SF
 14
Bruno Colmenares, Camila
20 1:21,97
PEN ÑAL
 14
Hafon, Gabriela
21 1:22,29
MAYOR
 13
Reyes, Fernanda
22 1:22,52
CDEP
 13
Mun ñoz Barrios, Emilia
23 1:22,64
SF
 13
Torres Reina, Brianna
24 1:22,75
ARENA
 14
Perez, Francisca
25 1:22,99
MAGAL
 13
Valdes, Isis
26 1:23,07
SF
 13
Jara Gallegos, Sofia
27 1:23,79
TEMUC
 13
Aliste, Josefina
28 1:24,20
MAYOR
 13
Saldes, Paz
29 1:24,30
HUMAN
 14
Moraga, Scarlette
30 1:24,38
ATAL
 13
Asenjo, Renata
31 1:24,45
PEN ÑAL
 13
Santana, Rocio
32 1:25,50
CDUC
 13	
Delgado Noches, Isidora Antonia	33 1:26,23
ATAL
 13
Ortiz, Paula
34 1:26,76
CDEP
 13
Abate, Antonia
35 1:28,07
ATAL
 14
Moya Henriquez, Antonia
36 1:28,19
CDUC
 13
Venegas, Isidora
37 1:29,47
SI
 13
Lagos, Rocio
38 1:30,90
APS
 14	
Gonzalez Vega, Francisca Antonia	39 1:32,56
MAKO
 13
Ortubia, Gabriela
40 1:34,51	
 Evento 90  Mujeres 15-16 100 CL Metro Estilo de Espalda
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 16
Saldes, Paloma
1 1:10,80  9
SI
 16
Collingwoord, Camila
2 1:13,36  7
MAYOR
 16
Valdes, Javiera
3 1:13,62  6
ATAL
 15
Robles, Roberta
4 1:13,86  5
WFE
 15
Martorel, Micaela
5 1:13,98  4
SEREN
 15
Carrion, Luna
6 1:15,02  3
AV
 16
Gomez Fett, Paulina
7 1:15,10  2
EE
 15
Quiroga, Renata
8 1:16,30  1
 Evento 90  Mujeres 15-16 100 CL Metro Estilo de Espalda
   Equipo	Nombre Tiempo de Finales
MAYOR
 16
Saldes, Paloma
1 1:11,61q
MAYOR
 16
Valdes, Javiera
2 1:13,96q
ATAL
 15
Robles, Roberta
3 1:14,72q
SI
 16
Collingwoord, Camila
4 1:14,95q
WFE
 15
Martorel, Micaela
5 1:15,03q
AV
 16
Gomez Fett, Paulina
6 1:15,66q
EE
 15
Quiroga, Renata
7 1:16,12q
SEREN
 15
Carrion, Luna
8 1:16,18q
ARENA
 16
Medina, Cosntanza
9 1:17,17
ATAL
 16
Zamora Torres, Laura
10 1:17,18
HUMAN
 15
Dirricarrere, Antonia
11 1:17,81
SI
 15
Gomez, Renata
12 1:18,14
TEMUC
 15
Melinao, Constanza
13 1:18,90
ARENA
 15
Gajardo, Martina
14 1:20,76
AV
 15
Medina Solis, Jazmin
15 1:22,61
SF
 15
Palma Gajardo, Daniela
16 1:23,00
VIN ÑA
 15
Mun ñoz, Valentina
17 1:27,17
ARENA
 16
Reyes, Aranza
--- DQ	
 Evento 91  Mujeres 17-99 100 CL Metro Estilo de Espalda
   Equipo	Nombre	Tiempo de Finales	
EE
 23
Spuhr, Marianne
1 1:10,38  9
CDUC
 17
Bobadilla, Catalina
2 1:13,24  7
SI
 19
Diaz, Manuela
3 1:13,57  6
MAYOR
 19
Cea, Francisca
4 1:14,08  5
MAKO
 17
Quiroz, Fabiola
5 1:15,98  4
OHIGG
 17
Pen ñailillo Alfonso, Isidora
6 1:17,69  3
CDEP
 17	
Hernandez Mun ñoz, Constanza	7 1:20,20  2
MAYOR
 17
Poges, Valentina
8 1:20,99  1	
 Evento 91  Mujeres 17-99 100 CL Metro Estilo de Espalda
   Equipo	Nombre Tiempo de Finales
EE
 23
Spuhr, Marianne
1 1:11,15q
CDUC
 17
Bobadilla, Catalina
2 1:14,06q
SI
 19
Diaz, Manuela
3 1:14,40q
MAKO
 17
Quiroz, Fabiola
4 1:16,17q
MAYOR
 19
Cea, Francisca
5 1:16,29q
MAYOR
 17
Poges, Valentina
6 1:18,79q
CDEP
 17
Hernandez Mun ñoz, Constanza	7 1:20,75q
OHIGG
 17
Pen ñailillo Alfonso, Isidora
8 1:21,16q

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 34
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
...   (Evento 91  Mujeres 17-99 100 CL Metro Estilo de Espalda)	
Edad	   Equipo	Nombre
MAKO
 22
Jimenez, Margaret
9 1:21,55
ATAL
 17
Campos Hormazabal, Trinidad
10 1:21,82
AERO
 17
Ulloa, Bele án
11 1:24,02
OHIGG
 18
Droguett M, Sofia
12 1:24,35
MORRO
 19
Rojas, Daniella
13 1:26,83
 Evento 92  Hombres 13-14 100 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 14
Osorio, Manuel
1 54,78  9
MAYOR
 14
Lazzerini, Mariano
2 55,09  7
SF
 14
Marchesini Ayala, Alejandro
3 55,60  6
SI
 14
Madariaga, Lucas
4 56,26  5
SI
 14
Rau, Constantino
5 57,67  4
SF
 13
Cisternas Gomez, Eduardo
6 57,69  3
UNIDO
 14
Gustin, Daniel
7 59,28  2
TEMUC
 14
Gesche, Diego
8 59,32  1
 Evento 92  Hombres 13-14 100 CL Metro Estilo Libre
   Equipo	Nombre Tiempo de Finales
MAYOR
 14
Lazzerini, Mariano
1 54,81q
MAYOR
 14
Osorio, Manuel
2 55,18q
SI
 14
Madariaga, Lucas
3 56,51q
SF
 14
Marchesini Ayala, Alejandro
4 56,87q
SF
 13
Cisternas Gomez, Eduardo
5 57,83q
SI
 14
Rau, Constantino
6 58,24q
TEMUC
 14
Gesche, Diego
7 58,75q
UNIDO
 14
Gustin, Daniel
8 58,99q
EE
 14
Estevez, Simon
9 59,29
ATAL
 13
Sanchez, Sebastian
10 1:01,20
MAGAL
 14
Jara, Cristobal
11 1:01,27
SSWIM
 14
Rojas, Joaquin
12 1:01,42
WFE
 14
Franco, Guillermo
*13 1:01,50
AUTO
 13
Gonzalez, Benjamin
*13 1:01,50
SSWIM
 14
Pavez, Martíán
15 1:01,91
SSWIM
 14
Ramos, Santiago
16 1:01,93
SI
 13
Rodriguez, Agustin
17 1:02,11
ARENA
 14
Biscupovic, Nicolas
18 1:02,17
MAKO
 14
Andalaft, Ignacio
19 1:02,20
SF
 14
Tapia Aguilera, Pedro
20 1:02,71
SEREN
 14
Sepulveda, Vicente
21 1:03,19
SF
 13
Pazmin ño Riffo, Alexander
22 1:03,55
MAKO
 14
Fernandez, Alonso
23 1:03,76
MAKO
 14
Parra, Andres
24 1:03,77
CHIC-ZZ
 14
Munoz, Benjamin
25 1:03,95
ATAL
 14
Manriquez, Joaquin
26 1:03,96
UNIDO
 14
Lim, Sean
27 1:04,56
CDEP
 14
Valderrama, Lucas
28 1:04,97
HUMAN
 14
Henriquez, Cristian
29 1:04,98
SSWIM
 14
Annaratone, Daniel
30 1:05,00
ARSU
 14
Cevo, Enzo
31 1:05,48
MAKO
 13
Barra, Benjamin
32 1:05,79
ARSU
 13
Mun ñoz, Bruno
33 1:05,82
SI
 14
Galleguillos, Julian
34 1:06,01 MAKO
 13
Costas, Matias
35 1:06,06
VITAC
 13
Pilquiman, Nicolas
36 1:06,62
MAGAL
 13
Salazar, Alonso
37 1:06,99
TEMUC
 14
Saavedra, Pablo
38 1:07,14
AMARU
 14
Toledo, Alberto
39 1:07,20
APS
 14	
Romero Brizuen ño, Juan Pablo Sebastian
40 1:07,34
ATAL
 14
Esteves, Emilio
41 1:07,35
MAKO
 14
Gallardo, Sebastian
42 1:07,77
TMF
 13
Suarez, Pablo
43 1:08,08
CDUC
 14
Schwerter, Federico
44 1:08,24
ARENA
 13
Gatica, Leonardo
45 1:08,64
PEN ÑAL
 14
Godoy, Nicolas
46 1:09,09
EE
 14
Wensioe, Martin
47 1:09,40
TEMUC
 13
Moreno, Jose Pablo
48 1:09,55
CDUC
 14
Palma, Pablo
49 1:09,57
VITAC
 13
Venegas, Martin
50 1:09,77
ARENA
 13
Martinez, Tomas
*51 1:10,10
EE
 14
Bravo, Max
*51 1:10,10
MAGAL
 14
Berrios, Reinaldo
53 1:10,51
HUMAN
 13
Duarte, Felipe
54 1:10,55
CDEP
 14
Acevedo  Celedon, Matias
55 1:10,92
SEREN
 13
Vega, Cristobal
56 1:11,10
CDUC
 13
Pedemonte, Facundo
57 1:11,34
CDUC
 14
Dufflocq, Julio
58 1:11,58
VICEN
 14
Ramirez, Luciano
59 1:11,87
ARAU
 14
Olivares, Gabriel
60 1:12,29
SEREN
 13
Saez, Alex
61 1:14,07
 Evento 93  Hombres 15-16 100 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
UNIDO
 16
Schnapp, Benjamin
1 53,64  9
MAYOR
 16
Olivos, Lucas
2 54,96  7
MAGAL
 16
Cespedes, Diego
3 55,95  6
CDEP
 15
Toledo, Luis
4 56,75  5
WFE
 15
Lerzundi, Sebastian
5 57,18  4
SF
 16
Ortiz Mun ñoz, Vicente
6 57,55  3
AV
 16
Salgado Suarez, Martin
7 58,57  2
HUMAN
 16
Torres, Maximiliano
8 58,77  1
 Evento 93  Hombres 15-16 100 CL Metro Estilo Libre
   Equipo	Nombre Tiempo de Finales
UNIDO
 16
Schnapp, Benjamin
1 54,18q
MAYOR
 16
Olivos, Lucas
2 54,73q
MAGAL
 16
Cespedes, Diego
3 56,90q
WFE
 15
Lerzundi, Sebastian
4 57,38q
SF
 16
Ortiz Mun ñoz, Vicente
5 57,48q
CDEP
 15
Toledo, Luis
6 58,02q
HUMAN
 16
Torres, Maximiliano
7 58,51q
AV
 16
Salgado Suarez, Martin
8 58,69q
ATAL
 16
Mena, Santiago
9 58,77
WFE
 15
Bratz, Octavio
10 58,81
SF
 15
Medina Rios, Samuel
11 59,12
SSWIM
 15
Baeza, Nicola ás
12 59,98
SF
 16
Bastias Barra, Cristobal
13 1:00,08
MAYOR
 15
Reyes, Benjamin
14 1:00,12

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 35
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
...   (Evento 93  Hombres 15-16 100 CL Metro Estilo Libre)	
Edad	   Equipo	Nombre Tiempo de Finales
SEREN
 15
Bernal, Pacual
15 1:00,18
WFE
 15
Conus, Sergio
16 1:00,30
OHIGG
 16
Negrete, Arturo
17 1:00,31
UNIDO
 16
Bravo, Benjamin
18 1:00,68
WFE
 15
Martinez, Vicente
19 1:00,73
AMARU
 16
Zabala, Joaquin
20 1:00,81
UNIDO
 15
Querales, Marcos
21 1:01,19
UNIDO
 15
De la Vega, Rafael
22 1:01,38
VIN ÑA
 16
Martinez, Alexandro
23 1:01,49
SEREN
 15
Navia, Matias
24 1:01,74
CDUC
 15
Dominguez, Enrique
25 1:02,44
AUTO
 15
Zepeda, Agustin
26 1:02,54
CDUC
 16
Luttges, Arturo
27 1:02,66
WFE
 15
Orizola, Sebastian
28 1:02,73
CDEP
 16
Vergara, Gabriel
29 1:03,13
TMF
 16
Arias, Francisco
30 1:03,27
ATAL
 15
Barros Palma, Benjamin
*31 1:03,32
ARAU
 15
Carvajal, Luciano
*31 1:03,32
MASSS
 16
Guarin, David
33 1:03,43
VICEN
 15
Antonio, Silva
34 1:03,65
APS
 16
Castellanos Villela, Cristian Daniel
35 1:03,85
TMF
 15
Riquelme, Joaquin
36 1:04,50
HUMAN
 16
Camus, Patricio
37 1:04,58
HUMAN
 15
Agurto, Lucas
38 1:04,66
MAKO
 16
Araya, Felipe
39 1:04,79
AUTO
 16
Barrera, Juan
40 1:05,96
AMARU
 16
Meza, Pablo
41 1:06,27
MAKO
 15
Dinamarca, Diego
42 1:06,31
ARSU
 15
Ibarra, Fabian
43 1:06,98
MAGAL
 15
Valenzuela, Joaquin
44 1:08,27
CDUC
 16
Romero, Diego
45 1:08,79
ATAL
 15
Izquierdo, Renato
46 1:10,65
 Evento 94  Hombres 17-99 100 CL Metro Estilo Libre
   Equipo	Nombre	Tiempo de Finales	
MAKO
 30
Elliot, Oliver
1 52,65  9
SF
 19
Perdomo Almiro án, Jose á
2 52,91  7
EE
 26
Varas, Carlos
3 53,12  6
MAYOR
 18
Araya, Gabriel
4 53,79  5
EE
 19
Cruz, Emilio
5 54,06  4
VIN ÑA
 17
Araya, Vicente
6 54,48  3
UNIDO
 18
Ragazzone, Clemente
7 55,23  2
UNIDO
 18
Bustamante, Hugo
8 55,42  1
 Evento 94  Hombres 17-99 100 CL Metro Estilo Libre
   Equipo	Nombre Tiempo de Finales
SF
 19
Perdomo Almiro án, Jose á
1 54,37q
EE
 19
Cruz, Emilio
2 55,42q
EE
 26
Varas, Carlos
3 55,45q
MAYOR
 18
Araya, Gabriel
4 55,53q
VIN ÑA
 17
Araya, Vicente
5 55,59q
UNIDO
 18
Bustamante, Hugo
6 55,82q
MAKO
 30
Elliot, Oliver
7 56,11q
UNIDO
 18
Ragazzone, Clemente
8 56,21q EE
 17
Quiroga, Augusto
9 56,43
SI
 21
Molina, Diego
10 56,61
MAYOR
 17
Cea, Arturo
11 56,70
UNIDO
 19
Letelier, Tomas P
12 57,03
ATAL
 19
Korzeniowski, Facundo
13 57,07
SEREN
 17
Saez, Matias
14 57,08
SI
 23
Marchetti, Martin
15 57,39
EE
 32
Carriles, Francisco
16 57,55
EE
 25
Labra, Felipe
17 57,82
ARENA
 17
Soto, Nicolas
18 57,92
EE
 26
Farias, Jose Ignacio
19 58,27
HUMAN
 24
Romo, Pablo
20 58,38
UNIDO
 18
Lara, Joaquin
21 58,44
EE
 35
Peruga, Alberto
22 58,93
MAYOR
 18
Azocar, Matias
23 59,33
SF
 24
Perey Fica, Javier
24 59,39
MAKO
 17
Estay, Ignacio
25 59,74
HUMAN
 18
Fuentes, Marcelo
26 59,89
SI
 27
Isla, Alejandro
27 1:00,22
SF
 23
Velasquez, Hugo
28 1:00,31
HUMAN
 17
Retamal, Martin
29 1:01,79
EE
 19
Fernandez, Max
30 1:01,93
AMARU
 17
Antiguay, Matias
31 1:01,94
MAKO
 18
Lucares, Alejandro
32 1:02,69
ATAL
 24	
Gonzalez Rojas, Claudio Matias	33 1:02,78
AERO
 18
Ortega, Joaquíán
34 1:02,79
SEREN
 17
Bustos, Cristobal
35 1:04,75
MAKO
 22
Olea, David
36 1:04,86
MAYOR
 17
Aracena, Yamil
37 1:10,98
 Evento 95  Mujeres 13-14 100 CL Metro Estilo de Pecho
   Equipo	Nombre	Tiempo de Finales	
MAYOR
 14
Cubillos, Antonia
1 1:17,60  9
EE
 14
Bennewitz, Catalina
2 1:19,85  7
SSWIM
 13
Moyano, Josefina
3 1:22,11  6
MAYOR
 13
Solis, Paulina
4 1:23,75  5
UNIDO
 13
Reginato, Maria Belen
5 1:25,47  4
ARENA
 13
Molina, Natalia
6 1:27,04  3
MAGAL
 14
Andersen, Sophia
7 1:27,49  2
MORRO
 13
Blanco, Valentina
8 1:28,79  1
 Evento 95  Mujeres 13-14 100 CL Metro Estilo de Pecho
   Equipo	Nombre Tiempo de Finales
MAYOR
 14
Cubillos, Antonia
1 1:19,37q
EE
 14
Bennewitz, Catalina
2 1:21,89q
SSWIM
 13
Moyano, Josefina
3 1:23,15q
MAYOR
 13
Solis, Paulina
4 1:24,20q
UNIDO
 13
Reginato, Maria Belen
5 1:25,92q
ARENA
 13
Molina, Natalia
6 1:27,60q
MORRO
 13
Blanco, Valentina
7 1:29,39q
MAGAL
 14
Andersen, Sophia
8 1:30,43q
ATAL
 13
Ortiz, Paula
9 1:30,60
N ÑIELO
 13
Iturriaga, Soraya
10 1:31,36
HUMAN
 14
Henriquez, Sofia
11 1:33,07
ARENA
 13
Ampuero, Martina
12 1:33,40

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 36
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
...   (Evento 95  Mujeres 13-14 100 CL Metro Estilo de Pecho)	
Edad	   Equipo	Nombre Tiempo de Finales
MAGAL
 13
Cabello, Giuliana
13 1:33,87
MAGAL
 14
Ortega, Constanza
14 1:34,91
CDEP
 14
Solano, Sofia
15 1:35,92
LAUTA
 13
Mora, Alen
16 1:36,76
APS
 14
Gonzalez Vega, Francisca Antonia	17 1:37,71
CDEP
 14
Bustos, Renata Paz
18 1:37,72
AUTO
 13
Cordova, Josefina
19 1:38,67
OHIGG
 14
Leiva Polanco, Sofia
20 1:39,11
APS
 13	
Sepulveda Tapia, Valentina Sofíáa
21 1:39,58
ARAU
 13
Gil Rivera, Ana
22 1:40,79
SEREN
 13
Diaz, Antonia
23 1:42,56
HUMAN
 13
Gonzalez, Catalina
24 1:42,85
AMARU
 14
Armijo, Almendra
25 1:44,80
OHIGG
 13
Perromat Villacura, Martina
26 1:45,00
 Evento 96  Mujeres 15-16 100 CL Metro Estilo de Pecho
   Equipo	Nombre	Tiempo de Finales
MAYOR
 15
Matsubara, Key
1 1:19,84  9
MAYOR
 15
Palomino, Naiomi
2 1:21,80  7
ARENA
 16
Medina, Cosntanza
3 1:28,52  6
CDUC
 15
Pen ña, Beatriz
4 1:28,97  5
WFE
 15
Martorel, Micaela
5 1:31,87  4
MAKO
 16
Acun ña, Sofia
6 1:34,63  3
EE
 16
Brito, Carolina
7 1:35,08  2
COQUI
 16
Rojas, Carolina
8 1:35,96  1
 Evento 96  Mujeres 15-16 100 CL Metro Estilo de Pecho
   Equipo	Nombre Tiempo de Finales
MAYOR
 15
Matsubara, Key
1 1:17,65q
MAYOR
 15
Palomino, Naiomi
2 1:19,87q
ARENA
 16
Medina, Cosntanza
3 1:22,18q
WFE
 15
Martorel, Micaela
4 1:26,00q
COQUI
 16
Rojas, Carolina
5 1:29,00q
MAKO
 16
Acun ña, Sofia
6 1:29,02q
CDUC
 15
Pen ña, Beatriz
7 1:29,20q
EE
 16
Brito, Carolina
8 1:35,25q	
 Evento 97  Mujeres 17-99 100 CL Metro Estilo de Pecho
   Equipo	Nombre	Tiempo de Finales	
SSWIM
 23
Chanuar, Leila
1 1:17,02  9
SEREN
 18
Torres, Pamela
2 1:20,16  7
APS
 18
Bru üning Belmar, Maríáa Jose á
3 1:21,90  6
HUMAN
 20
Pinto, Javiera
4 1:22,20  5
AUTO
 18
Zepeda, Victoria
5 1:22,92  4
OHIGG
 19	
Pen ñailillo Alfonso, Anita Cristina
6 1:23,95  3
SI
 22
Zecheto, Alessia
7 1:26,78  2
UNIDO
 17
Mauriziano, Chiara
8 1:27,98  1	
 Evento 97  Mujeres 17-99 100 CL Metro Estilo de Pecho
   Equipo	Nombre Tiempo de Finales
SSWIM
 23
Chanuar, Leila
1 1:18,23q
SEREN
 18
Torres, Pamela
2 1:21,84q HUMAN
 20
Pinto, Javiera
3 1:23,36q
APS
 18
Bru üning Belmar, Maríáa Jose á
4 1:23,55q
AUTO
 18
Zepeda, Victoria
5 1:23,93q
OHIGG
 19	
Pen ñailillo Alfonso, Anita Cristina
6 1:25,54q
UNIDO
 17
Mauriziano, Chiara
7 1:27,83q
SI
 22
Zecheto, Alessia
8 1:28,77q
ARSU
 17
Lopez, Rocio
9 1:29,51
MAKO
 22
Thoma, Kathi
10 1:29,54
CDUC
 25
Chamorro, Alejandra
11 1:30,57
CHIC-ZZ
 17
Fernandez, Constanza
12 1:32,18
MAYOR
 17
Crisostomo, Maira
13 1:35,60	
 Evento 98  Hombres 13-14 400 CL Metro CI
Equipo	Nombre	Tiempo de Finales	
HUMAN
 13
Cereceda, Maximiliano
1 4:55,23  9
MAYOR
 14
Menendez, Jose
2 5:07,71  7
SI
 14
Montagna, Vicente
3 5:09,99  6
ARENA
 13
Henriquez, Martin
4 5:18,03  5
ATAL
 13	
Campos Hormazabal, Trinidad
5 5:20,41  4
AUTO
 13
Hewstone, Felipe
6 5:29,34  3
MAGAL
 13
Green, Vicente
7 5:29,62  2
AUTO
 14
Murillo, Rodrigo
8 5:30,07  1
EE
 13
Salazar, Andoni
9 5:31,13
ARENA
 14
Castillo, Nicolas
10 5:37,34
UNIDO
 13
Schnapp, Rafael
11 5:38,24
CDEP
 13
Moreno Paffetti, Martin
12 5:40,75
ATAL
 13	
Pe árez Fuenzalida, Alonso Alejandro
13 5:43,59
APS
 13
Melin Del Valle, Reiner Alario
14 5:43,87
ATAL
 14
Parada, Benjamin
15 5:45,86
AUTO
 14
Galleguillos, Lorenzo
16 5:47,83
SF
 13
Alonso Vasquez, Pablo
17 5:54,85
ARENA
 13
Gomez, David
18 5:56,09
SI
 13
Marin, Santiago
--- DQ
MAYOR
 13
Barriga, Sebastian
--- DQ
 Evento 99  Hombres 15-16 400 CL Metro CI
Equipo	Nombre	Tiempo de Finales	
ATAL
 15
Martinez, Diego
1 4:48,85  9
DPA
 16
Jimenez, Felipe
2 5:03,42  7
SI
 15
Aycauer, Vicente
3 5:14,37  6
CHIC-ZZ
 15
Bobadilla, Patricio
4 5:15,12  5
WFE
 15
Martinez, Vicente
5 5:16,22  4
SF
 16
Moreno Sahlie, Ignacio
6 5:18,06  3
MAYOR
 15
Urtubia, Jorge
7 5:23,34  2
MAGAL
 15
Alvarado, Matias
8 5:27,58  1
MAKO
 16
Flores, Gabriel
9 5:32,55
APS
 15	
Gonzalez Moreno, Diego Rodrigo	10 5:38,28
CDUC
 16
Ca áceres, Joaquin
11 5:39,33
ATAL
 16
Gonzalez Olivares, Thomas
12 5:42,86
ATAL
 15
Izquierdo, Renato
13 6:05,60
AV
 16	
Hansen Tatter, Gerhart Nicholas	--- DQ	
 Evento 100  Hombres 17-99 400 CL Metro CI
Equipo	Nombre	Tiempo de Finales	
SI
 20
Ahumada, Maximiliano
1 4:47,39  9
MAYOR
 18
Araya, Gabriel
2 4:53,41  7
SI
 23
Quiroz, Felipe
3 5:03,51  6
HUMAN
 21
Torres, Giovanni
4 5:07,44  5

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 37
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
(Evento 100  Hombres 17-99 400 CL Metro CI)    Equipo	Nombre	Tiempo de Finales	
MAGAL
 17
Tapia, Elian
5 5:28,54  4
ARAU
 17
Martinez, Eduardo
6 5:36,28  3	
 Evento 101  Mujeres 13-14 400 CL Metro Combinado Relevo
 	
Relevo	Equipo	Tiempo de Finales	
Finales A
MAYOR
1 4:50,69  18
1) Ardiles, Trinidad 14 2) Cubillos, Antonia 14
3) Solis, Paulina 13 4) Gonzales, Magdalena 13
A
SSWIM
2 4:55,39  14
1) Castro, Daniela 13 2) Moyano, Josefina 13
3) Gonza ález, Fernanda 14 4) Díáaz, Millaray 13
A
ATAL
3 5:04,74  12
1) Castro Gonzalez, Antonia 14 2) Ortiz, Paula 13	
3) Concha Marquez, Florencia Paz 13	4) Asenjo, Renata 13
A
UNIDO
4 5:05,00  10
1) Custodio, Bruna 14 2) Reginato, Maria Belen 13
3) Figueroa, Amanda 13 4) Bunce, Kennedy 13
A
SI
5 5:05,85  8
1) Barrenechea, Alemka 13 2) Reyes, Fernanda 14
3) Ramirez, Pia 14 4) Cepeda, Maria Jesus 13
A
CDEP
6 5:13,10  6
1) Anabalon, Sofia 13 2) Solano, Sofia 14
3) Mun ñoz Barrios, Emilia 13 4) Bustos, Renata Paz 14
A
ARENA
7 5:13,28  4
1) Farmer, Holly 13 2) Molina, Natalia 13
3) Ampuero, Martina 13 4) Perez, Francisca 14
A
MAGAL
8 5:20,53  2
1) Valdes, Isis 13 2) Cabello, Giuliana 13
3) Ortega, Constanza 14 4) Andersen, Sophia 14	
 Evento 101  Mujeres 13-14 400 CL Metro Combinado Relevo
 	
Relevo	Equipo Tiempo de Finales
A
MAYOR
1 4:39,00q
1) Ardiles, Trinidad 14 2) Cubillos, Antonia 14
3) Solis, Paulina 13 4) Gonzales, Magdalena 13
A
SSWIM
2 4:55,00q
1) Castro, Daniela 13 2) Moyano, Josefina 13
3) Gonza ález, Fernanda 14 4) Díáaz, Millaray 13
A
UNIDO
3 4:55,14q
1) Custodio, Bruna 14 2) Reginato, Maria Belen 13
3) Figueroa, Amanda 13 4) Bunce, Kennedy 13
A
ATAL
4 5:00,00q
1) Castro Gonzalez, Antonia 14 2) Ortiz, Paula 13
3) Concha Marquez, Florencia Paz 13	4) Asenjo, Renata 13
A
CDEP
5 5:09,23q
1) Anabalon, Sofia 13 2) Solano, Sofia 14
3) Mun ñoz Barrios, Emilia 13 4) Bustos, Renata Paz 14
A
ARENA
6 5:16,00q
1) Farmer, Holly 13 2) Molina, Natalia 13
3) Ampuero, Martina 13 4) Perez, Francisca 14
A
SI
7 5:16,02q
1) Barrenechea, Alemka 13 2) Reyes, Fernanda 14
3) Ramirez, Pia 14 4) Cepeda, Maria Jesus 13
A
MAGAL
8 5:20,00q
1) Valdes, Isis 13 2) Andersen, Sophia 14
3) Ortega, Constanza 14 4) Cabello, Giuliana 13	
 Evento 102  Mujeres 15-16 400 CL Metro Combinado Relevo
 	
Relevo	Equipo	Tiempo de Finales	
Finales A
MAYOR
1 4:53,16  18
1) Palomino, Naiomi 15 2) Matsubara, Key 15
3) Lewis, Diana 16 4) Bustamante, Catalina 16
A
SI
2 5:09,30  14
1) Gomez, Renata 15 2) Collingwoord, Camila 16
3) Zamora, Alicia 16 4) Barrenechea, Krasna 15
A
CDEP
3 5:22,59  12
1) Mun ñoz, Matilde 16 2) Llunell Vilte, Janett 15
3) Smith, Catalina 15 4) Balderas, Tania 15
 Evento 102  Mujeres 15-16 400 CL Metro Combinado Relevo
 	
Relevo	Equipo Tiempo de Finales
A
MAYOR
1 4:37,00q
1) Valdes, Javiera 16 2) Palomino, Naiomi 15
3) Lewis, Diana 16 4) Bustamante, Catalina 16
A
CDEP
2 5:14,56q
1) Zavala, Aranzazu 15 2) Llunell Vilte, Janett 15
3) Smith, Catalina 15 4) Balderas, Tania 15
A
SI
3 5:15,02q
1) Gomez, Renata 15 2) Collingwoord, Camila 16
3) Zamora, Alicia 16 4) Barrenechea, Krasna 15	
 Evento 102  Mujeres 17-99 400 CL Metro Combinado Relevo
 	
Relevo	Equipo	Tiempo de Finales	
Finales A
SI
1 4:46,95  18
1) Diaz, Manuela 19 2) Zecheto, Alessia 22
3) Perez, Paola 27 4) Valdivia, Mahina 22
A
ATAL
2 4:50,06  14
1) Bravo, Claudia 23 2) Fuenzalida, Valentina 17
3) Gutierrez, Savka 20	
4) Campos Hormazabal, Trinidad 17
A
MAKO
3 5:05,96  12
1) Quiroz, Fabiola 17 2) Thoma, Kathi 22
3) Olivares, Carolina 24 4) Ramirez, Maria Victoria 19
A
OHIGG
4 5:13,21  10
1) Droguett M, Sofia 18
2) Pen ñailillo Alfonso, Anita Cristina 19	
3) Pen ñailillo Alfonso, Isidora 17 4) Escobar Molina, Sara 19
A
MAYOR
5 5:16,01  8
1) Cea, Francisca 19 2) Crisostomo, Maira 17
3) Poges, Valentina 17 4) Castillo, Emilia 25	
 Evento 102  Mujeres 17-99 400 CL Metro Combinado Relevo
 	
Relevo	Equipo Tiempo de Finales
A
ATAL
1 4:44,00q
1) Bravo, Claudia 23 2) Fuenzalida, Valentina 17
3) Gutierrez, Savka 20	
4) Campos Hormazabal, Trinidad 17
A
MAYOR
2 4:49,00q
1) Cea, Francisca 19 2) Crisostomo, Maira 17
3) Poges, Valentina 17 4) Castillo, Emilia 25
A
MAKO
3 4:52,00q
1) Ramirez, Maria Victoria 19 2) Jimenez, Margaret 22
3) Olivares, Carolina 24 4) Thoma, Kathi 22

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 38
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
...   (Evento 102  Mujeres 17-99 400 CL Metro Combinado Relevo)	
 Relevo	Equipo Tiempo de Finales
A
SI
4 5:14,58q
1) Diaz, Manuela 19 2) Zecheto, Alessia 22
3) Perez, Paola 27 4) Valdivia, Mahina 22
A
OHIGG
5 5:15,00q
1) Droguett M, Sofia 18	
2) Pen ñailillo Alfonso, Anita Cristina 19	
3) Pen ñailillo Alfonso, Isidora 17 4) Escobar Molina, Sara 19	
 Evento 103  Hombres 13-14 400 CL Metro Estilo Libre Relevo
 	
Relevo	Equipo	Tiempo de Finales	
Finales A
SI
1 3:49,77  18
1) Madariaga, Lucas 14 2) Rau, Constantino 14
3) Marin, Santiago 13 4) Montagna, Vicente 14
A
MAYOR
2 3:51,86  14
1) Osorio, Manuel 14 2) Barriga, Sebastian 13
3) Lazzerini, Mariano 14 4) Menendez, Jose 14
A
SF
3 3:58,13  12
1) Cisternas Gomez, Eduardo 13 2) Pazminño Riffo, Alexander 13
3) Tapia Aguilera, Pedro 14 4) Marchesini Ayala, Alejandro 14
A
ATAL
4 4:04,97  10	
1) Campos Hormazabal, Benjamin 13	2) Sanchez, Sebastian 13
3) Parada, Benjamin 14 4) Pavez Hormazabal, Cristian 14
A
SSWIM
5 4:08,59  8
1) Rojas, Joaquin 14 2) Annaratone, Daniel 14
3) Ramos, Santiago 14 4) Pavez, Martíán 14
A
MAKO
6 4:10,75  6
1) Parra, Andres 14 2) Costas, Matias 13
3) Fernandez, Alonso 14 4) Andalaft, Ignacio 14
A
ARENA
7 4:13,36  4
1) Biscupovic, Nicolas 14 2) Cubillos, Vicente 14
3) Henriquez, Martin 13 4) Castillo, Nicolas 14
A
AUTO
8 4:15,08  2
1) Hewstone, Felipe 13 2) Murillo, Rodrigo 14
3) Galleguillos, Lorenzo 14 4) Gonzalez, Benjamin 13	
 Evento 103  Hombres 13-14 400 CL Metro Estilo Libre Relevo
 	
Relevo	Equipo Tiempo de Finales
A
SI
1 3:54,65q
1) Madariaga, Lucas 14 2) Rau, Constantino 14
3) Marin, Santiago 13 4) Montagna, Vicente 14
A
MAYOR
2 3:57,54q
1) Osorio, Manuel 14 2) Barriga, Sebastian 13
3) Lazzerini, Mariano 14 4) Menendez, Jose 14
A
SF
3 4:02,08q
1) Cisternas Gomez, Eduardo 13 2) Pazminño Riffo, Alexander 13
3) Tapia Aguilera, Pedro 14 4) Marchesini Ayala, Alejandro 14
A
ATAL
4 4:04,80q
1) Campos Hormazabal, Benjamin 13	2) Sanchez, Sebastian 13
3) Parada, Benjamin 14 4) Pavez Hormazabal, Cristian 14
A
SSWIM
5 4:09,40q
1) Rojas, Joaquin 14 2) Annaratone, Daniel 14
3) Ramos, Santiago 14 4) Pavez, Martíán 14
A
ARENA
6 4:13,34q
1) Cubillos, Vicente 14 2) Biscupovic, Nicolas 14
3) Henriquez, Martin 13 4) Castillo, Nicolas 14 A
MAKO
7 4:16,51q
1) Barra, Benjamin 13 2) Costas, Matias 13
3) Fernandez, Alonso 14 4) Andalaft, Ignacio 14
A
AUTO
8 4:18,57q
1) Hewstone, Felipe 13 2) Murillo, Rodrigo 14
3) Galleguillos, Lorenzo 14 4) Gonzalez, Benjamin 13
A
UNIDO
9 4:21,11
1) Lim, Sean 14 2) Schnapp, Rafael 13
3) Yan ñez, Francisco 14 4) Gustin, Daniel 14
A
EE
10 4:22,27
1) Estevez, Simon 14 2) Salazar, Andoni 13
3) Bravo, Max 14 4) Wensioe, Martin 14
A
MAGAL
11 4:23,62
1) Jara, Cristobal 14 2) Green, Vicente 13
3) Berrios, Reinaldo 14 4) Salazar, Alonso 13
A
CDEP
12 4:33,41
1) Moreno Paffetti, Martin 13 2) Acevedo  Celedon, Matias 14
3) Valderrama, Lucas 14 4) Elgueta, Marco Antonio 14
A
CDUC
13 4:44,75
1) Palma, Pablo 14 2) Pedemonte, Facundo 13
3) Schwerter, Federico 14 4) Dufflocq, Julio 14
A
SEREN
14 4:48,82
1) Sepulveda, Vicente 14 2) Torres, Ismael 13
3) Saez, Alex 13 4) Vega, Cristobal 13	
 Evento 104  Hombres 15-16 400 CL Metro Estilo Libre Relevo
 	
Relevo	Equipo	Tiempo de Finales	
Finales A
WFE
1 3:53,14  18
1) Conus, Sergio 15 2) Martinez, Vicente 15
3) Bratz, Octavio 15 4) Lerzundi, Sebastian 15
A
MAYOR
2 3:53,38  14
1) Olivos, Lucas 16 2) Olivos, Joaquin 16
3) Urtubia, Jorge 15 4) Reyes, Benjamin 15
A
SF
3 3:55,19  12
1) Medina Rios, Samuel 15 2) Moreno Sahlie, Ignacio 16
3) Bastias Barra, Cristobal 16 4) Ortiz Munñoz, Vicente 16
A
UNIDO
4 3:57,00  10
1) Querales, Marcos 15 2) De la Vega, Rafael 15
3) Bravo, Benjamin 16 4) Schnapp, Benjamin 16
A
ATAL
5 3:57,57  8
1) Martinez, Diego 15 2) Mena, Santiago 16
3) Gonzalez Olivares, Thomas 16 4) Barros Palma, Benjamin 15
A
MAKO
6 4:12,03  6
1) Araya, Felipe 16 2) Aguirre, Matias 15
3) Dinamarca, Diego 15 4) Flores, Gabriel 16
A
CDUC
7 4:14,86  4
1) Luttges, Arturo 16 2) Romero, Diego 16
3) Ca áceres, Joaquin 16 4) Dominguez, Enrique 15
A
CDEP
8 4:15,05  2
1) Toledo, Luis 15 2) Martinez, Sebastian 16
3) Vergara, Gabriel 16 4) Castellanos, Cristobal 15
 Evento 104  Hombres 15-16 400 CL Metro Estilo Libre Relevo
 	
Relevo	Equipo Tiempo de Finales
A
MAYOR
1 3:46,00q
1) Olivos, Lucas 16 2) Olivos, Joaquin 16
3) Urtubia, Jorge 15 4) Reyes, Benjamin 15

Natatorio ChilenoHY-TEK&#39;s MEET MANAGER 7.0 - 7:03 PM  01-07-2018  Paágina 39
Campeonato Nacional de Invierno 2018 - 28-06-2018 a 01-07-2018	
Resultados	
...   (Evento 104  Hombres 15-16 400 CL Metro Estilo Libre Relevo)	
 Relevo	Equipo Tiempo de Finales
A
UNIDO
2 3:50,14q
1) Querales, Marcos 15 2) De la Vega, Rafael 15
3) Bravo, Benjamin 16 4) Schnapp, Benjamin 16
A
WFE
3 3:56,00q
1) Conus, Sergio 15 2) Martinez, Vicente 15
3) Bratz, Octavio 15 4) Lerzundi, Sebastian 15
A
ATAL
4 3:57,00q
1) Martinez, Diego 15 2) Mena, Santiago 16
3) Gonzalez Olivares, Thomas 16 4) Barros Palma, Benjamin 15
A
SF
5 3:57,01q
1) Medina Rios, Samuel 15 2) Moreno Sahlie, Ignacio 16
3) Bastias Barra, Cristobal 16 4) Ortiz Munñoz, Vicente 16
A
MAKO
6 4:10,00q
1) Flores, Gabriel 16 2) Dinamarca, Matias 15
3) Dinamarca, Diego 15 4) Araya, Felipe 16
A
CDUC
7 4:12,00q
1) Luttges, Arturo 16 2) Romero, Diego 16
3) Ca áceres, Joaquin 16 4) Dominguez, Enrique 15
A
CDEP
8 4:35,00q
1) Toledo, Luis 15 2) Martinez, Sebastian 16
3) Vergara, Gabriel 16 4) Castellanos, Cristobal 15	
 Evento 104  Hombres 17-99 400 CL Metro Estilo Libre Relevo
 	
Relevo	Equipo	Tiempo de Finales	
Finales A
MAYOR
1 3:40,04  18
1) Cea, Arturo 17 2) Aracena, Yamil 17
3) Sepulveda, Joaquin 23 4) Araya, Gabriel 18
A
EE
2 3:41,31  14
1) Quiroga, Augusto 17 2) Carriles, Francisco 32
3) Cruz, Emilio 19 4) Varas, Carlos 26
A
SI
3 3:41,52  12
1) Molina, Diego 21
3) Borello, Xoan 24 4) Ahumada, Maximiliano 20
A
UNIDO
4 3:42,04  10
1) Ragazzone, Clemente 18 2) Letelier, Tomas P 19
3) Quintanilla, Benjamin 21 4) Bustamante, Hugo 18
A
ATAL
5 4:00,36  8
1) Korzeniowski, Facundo 19 2) Furtado, Agustin 20
3) Chavez Hidalgo, Lukas 22	
4) Gonzalez Rojas, Claudio Matias 24	
 Evento 104  Hombres 17-99 400 CL Metro Estilo Libre Relevo
 	
Relevo	Equipo Tiempo de Finales
A
MAYOR
1 3:38,00q
1) Cea, Arturo 17 2) Aracena, Yamil 17
3) Sepulveda, Joaquin 23 4) Araya, Gabriel 18
A
EE
2 3:39,00q
1) Varas, Carlos 26 2) Quiroga, Augusto 17
3) Labra, Felipe 25 4) Cruz, Emilio 19
A
SI
*3 3:40,00q
1) Molina, Diego 21 2) Marchetti, Martin 23
3) Borello, Xoan 24 4) Ahumada, Maximiliano 20
A
SF
*3 3:40,00q
1) Perdomo Almiro án, Jose á 19 2) Navarrete Arenas, Tomas 19
3) Navarrete Arenas, Cristobal 24 4) Perey Fica, Javier 24 A
UNIDO
5 3:40,12q
1) Ragazzone, Clemente 18 2) Letelier, Tomas P 19
3) Quintanilla, Benjamin 21 4) Bustamante, Hugo 18
A
ATAL
6 3:48,00q
1) Prem, Juan Rodolfo 24 2) Furtado, Agustin 20	
3) Gonzalez Rojas, Claudio Matias 24	4) Korzeniowski, Facundo 19<br><br><br><br>";

$text = str_replace("Edad\n", "", $text);
$text = str_replace("Edad", "", $text);
$text = str_replace("Equipo", "", $text);
$text = str_replace("Nombre", "", $text);
$text = str_replace("Tiempo de Finales", "", $text);
$text = str_replace("Tiempo de Finales\n", "", $text);
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
            if ($pos2 !== false) {
                 $formato = 1;
              $evento = $linea;
              $control = 1;
              $sql = "INSERT INTO sys_Evento (CompetenciaId, Nombre) VALUES ('$id_campeonato', '$evento')";
                echo $sql;
                    $result = mysqli_query($connection, $sql);
                $evento_id = mysqli_insert_id($connection);
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
                        echo "<br><br><strong>linea 1</strong> \"".$linea."\"<br>";
                     } else if ($control == 2) {
                         echo "<strong>linea 2</strong> ".$linea."<br>";
                        $edad = $linea; 
                     } else if ($control == 3) {
                         echo "<strong>linea 3</strong> ".$linea."<br>";
                        $nadador = $linea; 
                     } else if ($control == 4) {
                         echo "<strong>linea 4</strong> ".$linea."<br>";
                        $tiempo1 = explode(" ", $linea);
                        $lugar = $tiempo1[0];
                        $tiempo = $tiempo1[1];
                        $puntos = $tiempo1[2];
                        $control = 0;
                     }
                  } else {
                      if ($control == 4) {
                        $club = $linea;
                        echo "<br><br><strong>linea 4</strong> \"".$linea."\"<br>";
                     } else if ($control == 1) {
                         echo "<strong>linea 1</strong> ".$linea."<br>";
                        $edad = $linea; 
                     } else if ($control == 2) {
                         echo "<strong>linea 2</strong> ".$linea."<br>";
                        $nadador = $linea; 
                     } else if ($control == 3) {
                         echo "<strong>linea 3</strong> ".$linea."<br>";
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
                    $result = mysqli_query($connection, $sql);
                }
              }
              $control ++;
            }
        }
        
      
    }
    
    
    

}
fclose($file);


?>