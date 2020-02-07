<?php

// Kreirane rute su sledece:
// GET liste>npr http://localhost:8080/todo/liste.json
// GET lista (po IDu)>npr http://localhost:8080/todo/liste/1.json
// GET itemi >npr http://localhost:8080/todo/itemi.json
// GET itemi (po IDu) >npr http://localhost:8080/todo/itemi/1.json
// POST item >npr http://localhost:8080/todo/itemi (prihavata json {"content":"nesto", "status":0,"list_id":1})
// POST lista >npr http://localhost:8080/todo/liste (prihavata json {"title":"nesto"})
// PUT lista >npr http://localhost:8080/todo/liste/1 (prihavata json {"title":"nesto"})
// PUT item >npr http://localhost:8080/todo/itemi/1 (prihavata json {"content":"nesto", "status":0,"list_id":1})
// DELETE item >npr http://localhost:8080/todo/itemi/1
// DELETE item >npr http://localhost:8080/todo/liste/1





require 'flight/Flight.php';
require 'jsonindent.php';


header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST, GET, DELETE, OPTIONS,PUT');
header('Access-Control-Allow-Headers: Content-Type');


Flight::register('db', 'Database', array('itehapp'));
$json_podaci = file_get_contents("php://input");
Flight::set('json_podaci', $json_podaci );

Flight::route('/', function(){
    echo 'ovde moze da ide homepage!';
});

Flight::route('OPTIONS /itemi', function(){
	return false;
});
Flight::route('OPTIONS /liste', function(){
	return false;
});
Flight::route('OPTIONS /itemi/@id', function($id){
	return false;
});
Flight::route('OPTIONS /liste/@id', function($id){
	return false;
});



Flight::route('GET /itemi/@id.json', function($id){
	header ("Content-Type: application/json; charset=utf-8");
	$db = Flight::db();
	$db->select("itemi", "*", "liste", "list_id", "id", "itemi.id = ".$id, null);
	$red=$db->getResult()->fetch_object();
	//JSON_UNESCAPED_UNICODE parametar je uveden u PHP verziji 5.4
	//Omogućava Unicode enkodiranje JSON fajla
	//Bez ovog parametra, vrši se escape Unicode karaktera
	//Na primer, slovo č će biti \u010
	$json_niz = json_encode ($red,JSON_UNESCAPED_UNICODE);
	echo indent($json_niz);
	return false;
});
Flight::route('GET /liste.json', function(){
	header ("Content-Type: application/json; charset=utf-8");
	$db = Flight::db();
	$db->select("liste", "*", null, null, null, null, null);
	$niz=array();
	$i=0;
	while ($red=$db->getResult()->fetch_object()){
		
		$niz[$i]["id"] = $red->id;
		$niz[$i]["title"] = $red->title;
		$db_pomocna=new Database("todo");
		$db_pomocna->select("itemi", "*", null, null, null, "itemi.list_id = ".$red->id, null);
		while ($red_pomocna=$db_pomocna->getResult()->fetch_object()){
			$niz[$i]["itemi"][]=$red_pomocna;
		}
		$i++;
	}
	//JSON_UNESCAPED_UNICODE parametar je uveden u PHP verziji 5.4
	//Omogućava Unicode enkodiranje JSON fajla
	//Bez ovog parametra, vrši se escape Unicode karaktera
	//Na primer, slovo č će biti \u010
	$json_niz = json_encode ($niz,JSON_UNESCAPED_UNICODE);
	echo indent($json_niz);
	return false;
});
Flight::route('GET /liste/@id.json', function($id){
	header ("Content-Type: application/json; charset=utf-8");
	$db = Flight::db();
	$db->select("liste", "*", null, null, null, "liste.id = ".$id, null);
	$niz=array();
	
	$red=$db->getResult()->fetch_object();
		
		$niz["id"] = $red->id;
		$niz["title"] = $red->title;
		$db_pomocna=new Database("todo");
		$db_pomocna->select("itemi", "*", null, null, null, "itemi.list_id = ".$red->id, null);
		while ($red_pomocna=$db_pomocna->getResult()->fetch_object()){
		$niz["itemi"][]=$red_pomocna;
		}

	//JSON_UNESCAPED_UNICODE parametar je uveden u PHP verziji 5.4
	//Omogućava Unicode enkodiranje JSON fajla
	//Bez ovog parametra, vrši se escape Unicode karaktera
	//Na primer, slovo č će biti \u010
	$json_niz = json_encode ($niz,JSON_UNESCAPED_UNICODE);
	echo indent($json_niz);
	return false;


});


Flight::route('POST /liste', function(){
	header ("Content-Type: application/json; charset=utf-8");
	$db = Flight::db();
	$podaci_json = Flight::get("json_podaci");
	$podaci = json_decode ($podaci_json);
	if ($podaci == null){
	$odgovor["poruka"] = "Niste prosledili podatke";
	$json_odgovor = json_encode ($odgovor);
	echo $json_odgovor;
	} else {
	if (!property_exists($podaci,'title')){
			$odgovor["poruka"] = "Niste prosledili korektne podatke";
			$json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
			echo $json_odgovor;
			return false;
	
	} else {
			$podaci_query = array();
			foreach ($podaci as $k=>$v){
				$v = "'".$v."'";
				$podaci_query[$k] = $v;
			}
			if ($db->insert("liste", "title", array($podaci_query["title"]))){
				$odgovor["poruka"] = "Lista je uspešno ubačena";
				$json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
				echo $json_odgovor;
				return false;
			} else {
				$odgovor["poruka"] = "Došlo je do greške pri ubacivanju liste";
				$json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
				echo $json_odgovor;
				return false;
			}
	}
	}	


});

Flight::route('GET /movies.json', function(){
	header ("Content-Type: application/json; charset=utf-8");
	$db = Flight::db();
	$db->select("film","*", null,null);
	$niz=array();
	while ($red=$db->getResult()->fetch_object()){
		$niz[] = $red;
	}
	//JSON_UNESCAPED_UNICODE parametar je uveden u PHP verziji 5.4
	//Omogućava Unicode enkodiranje JSON fajla
	//Bez ovog parametra, vrši se escape Unicode karaktera
	//Na primer, slovo č će biti \u010
	$json_niz = json_encode ($niz,JSON_UNESCAPED_UNICODE);
	echo indent($json_niz);
	return false;
});

Flight::route('GET /movie/@id', function($id){
	$db = Flight::db();
	$db->getMovieAndDirector($id);
	$red=$db->getResult()->fetch_object();
	$json_niz = json_encode ($red,JSON_UNESCAPED_UNICODE);
	echo indent($json_niz);
	return false;
});

Flight::route('GET /getReservations/@id', function($id){
	$db = Flight::db();
	$db->getReservation($id);
	$niz=array();
	while ($red=$db->getResult()->fetch_object()){
		$niz[] = $red;
	}
	$json_niz = json_encode ($niz,JSON_UNESCAPED_UNICODE);
	echo indent($json_niz);
	return false;
});

Flight::route('OPTIONS /liste/@id', function($id){
	return false;
});

Flight::route('GET /getMovie/@id', function($id){
	$db = Flight::db();
	$db->select("film", '*', " naziv LIKE '$id%'",null);
		$red=$db->getResult()->fetch_object();
		if ($red != null) {
		$json_niz = json_encode ($red,JSON_UNESCAPED_UNICODE);
		echo indent($json_niz);
		return false;
		}else {
		$odgovor["poruka"] = "Došlo je do greške pri učitavanju filma";
		$json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
		echo $json_odgovor;
		return false;
		}
});

Flight::route('OPTIONS /liste/@id', function($id){
	return false;
});

Flight::route('POST /reservation/@id', function($id){
	header ("Content-Type: application/json; charset=utf-8");
	$db = Flight::db();
	$podaci_json = Flight::get("json_podaci");
	$podaci = json_decode ($podaci_json);
	if ($podaci == null){
	$odgovor["poruka"] = "Niste prosledili podatke";
	$json_odgovor = json_encode ($odgovor);
	echo $json_odgovor;
	} else {
	if (!property_exists($podaci,'cards')){
			$odgovor["poruka"] = "Niste prosledili korektne podatke";
			$json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
			echo $json_odgovor;
			return false;
	
	} else {
			
			if ($db->updateCards($id, $podaci->cards)){
				if ($db->insert("rezervacije", "datum, brojKarata, filmId, korisnikId", array($podaci->date, $podaci->resCards, $id, $podaci->userId))){
					$odgovor["poruka"] ="Uspešno ste rezervisali karte!";
					$json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
					echo $json_odgovor;
					return false;
				}
			} else {
				$odgovor["poruka"] = "Došlo je do greške pri rezervaciji karata";
				$json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
				echo $json_odgovor;
				return false;
			}
	}
	}	

});

Flight::route('PUT /updateMovie/@id', function($id){
	header ("Content-Type: application/json; charset=utf-8");
	$db = Flight::db();
	$podaci_json = Flight::get("json_podaci");
	$p = json_decode ($podaci_json);
	if ($p == null){
	$odgovor["poruka"] = "Niste prosledili podatke";
	$json_odgovor = json_encode ($odgovor);
	echo $json_odgovor;
	} else {
	if (!property_exists($p,'naziv')){
			$odgovor["poruka"] = "Niste prosledili korektne podatke";
			$json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
			echo $json_odgovor;
			return false;
	
	} else {
		 $values = [];
		$keys = [];
		array_push($values, $p->naziv, $p->zanr, $p->godina, $p->trailer, $p->datum, $p->vreme, $p->opis, $p->reziser, $p->brojKarata, $p->url);
		array_push($keys, "naziv", "zanr", "godina", "trailer", "datum", "vreme", "opis", "reziser", "brojKarata", "url");
			if ($db->update("film",$id,$keys, $values)){
				$odgovor["poruka"] = "Film je uspešno izmenjen";
				$json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
				echo $json_odgovor;
				return false;
			} else {
				$odgovor["poruka"] = "Došlo je do greške pri izmeni filma";
				$json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
				echo $json_odgovor;
				return false;
			}
			
	}
	}	

});

Flight::route('POST /login', function(){
	header ("Content-Type: application/json; charset=utf-8");
	$db = Flight::db();
	$podaci_json = Flight::get("json_podaci");
	$podaci = json_decode ($podaci_json);
	$where =  "username='".$podaci->username."' and password='".$podaci->password."'";

			if ($db->select("korisnik","*","$where", null)) {
				$user= $db->getResult()->fetch_object();
				if ($user == null){
					$odgovor["poruka"] = 'Pogrešno korisničko ime ili lozinka!';
				}else {
				$odgovor["poruka"] = $user;
				}
				$json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
				echo $json_odgovor;
				return false;
			} else {
				$odgovor["poruka"] = "Došlo je pri logovanju";
				$json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
				echo $json_odgovor;
				return false;
			}


});


Flight::route('POST /addMovie', function(){
	header ("Content-Type: application/json; charset=utf-8");
	$db = Flight::db();
	$podaci_json = Flight::get("json_podaci");
	$p = json_decode ($podaci_json);

	$niz = [];
	array_push($niz, $p->naziv, $p->zanr, $p->godina, $p->trailer, $p->datum, $p->vreme, $p->opis, $p->reziser, $p->brojKarata, $p->url);
	//$values = "$p->naziv".","."$p->zanr".','."$p->godina".","."$p->trailer".","."$p->datum"
/*	if ($db->insert("film","naziv,zanr,godina,trailer,datum,vreme,opis,reziser,brojKarata,url", $niz)) {
		$odgovor["poruka"] = "Film je uspesno dodat";
		$json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
		echo $json_odgovor;
		return false;
	} else {*/
		
		$odgovor["poruka"] = $db->insert("film","naziv,zanr,godina,trailer,datum,vreme,opis,reziser,brojKarata,url", $niz);
		$json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
		echo $json_odgovor;
		return false;
//	}
});

Flight::route('PUT /liste/@id', function($id){
	header ("Content-Type: application/json; charset=utf-8");
	$db = Flight::db();
	$podaci_json = Flight::get("json_podaci");
	$podaci = json_decode ($podaci_json);
	if ($podaci == null){
	$odgovor["poruka"] = "Niste prosledili podatke";
	$json_odgovor = json_encode ($odgovor);
	echo $json_odgovor;
	} else {
	if (!property_exists($podaci,'title')){
			$odgovor["poruka"] = "Niste prosledili korektne podatke";
			$json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
			echo $json_odgovor;
			return false;
	
	} else {
			$podaci_query = array();
			foreach ($podaci as $k=>$v){
				$v = "'".$v."'";
				$podaci_query[$k] = $v;
			}
			if ($db->update("liste", $id, array('title'),array($podaci->title))){
				$odgovor["poruka"] = "Lista je uspešno izmenjena";
				$json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
				echo $json_odgovor;
				return false;
			} else {
				$odgovor["poruka"] = "Došlo je do greške pri izmeni liste";
				$json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
				echo $json_odgovor;
				return false;
			}
	}
	}	

});
Flight::route('DELETE /deleteMovie/@id', function($id){
		header ("Content-Type: application/json; charset=utf-8");
		$db = Flight::db();
		if ($db->delete("film", array("id"),array($id))){
				$odgovor["poruka"] = "Film je uspešno izbrisan";
				$json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
				echo $json_odgovor;
				return false;
		} else {
				$odgovor["poruka"] = "Došlo je do greške prilikom brisanja filma";
				$json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
				echo $json_odgovor;
				return false;
		
		}		
				
});


Flight::route('DELETE /liste/@id', function($id){
	header ("Content-Type: application/json; charset=utf-8");
	$db = Flight::db();
	if ($db->delete("liste", array("id"),array($id))){
			$odgovor["poruka"] = "Lista je uspešno izbrisana";
			$json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
			echo $json_odgovor;
			return false;
	} else {
			$odgovor["poruka"] = "Došlo je do greške prilikom brisanja liste";
			$json_odgovor = json_encode ($odgovor,JSON_UNESCAPED_UNICODE);
			echo $json_odgovor;
			return false;
	
	}		


});


Flight::start();
