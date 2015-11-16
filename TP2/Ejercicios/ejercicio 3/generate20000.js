conn = new Mongo("127.0.0.1:10003")
db = conn.getDB("test_sharding");

var document = {nombre: "pepito", password: "pepa11", zip: 140075, genero: "Femenino", edad:34, fecha_creacion: new Date('Sep 04, 1927')};

for (j = 0; j<25; j++) {
	for (i = 0; i<20000; i++) {
		cod_postal = Math.floor(100000 + Math.random()*999999); // random number in range [100000, 999999]
		var document = {nombre: "pepito", password: "pepa"+i, zip: cod_postal, genero: "Femenino", edad:34, fecha_creacion: new Date('Sep 04, 1927')};
	    db.people.insert(document);
		print(cod_postal);
		print(db.people.getShardDistribution());
	}
	print("--------------------");
}

//     Para correrlo:
//     ./mongo localhost:10003/test generate20000.js > outputSharding
//     En outputSharding queda el crudo para graficar
