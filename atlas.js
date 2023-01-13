const fs = require('fs');
const MongoClient = require('mongodb').MongoClient;

// const uri = "mongodb://admi:unaclavemaslarga123@justificaciones.ivaras.cl/?authSource=admin";
const uri = "mongodb://admi:unaclavemaslarga123@localhost/?authSource=admin";

let rawdata = fs.readFileSync('public/storage/justis.json');
let content = JSON.parse(rawdata);

const client = new MongoClient(uri, { useNewUrlParser: true, useUnifiedTopology: true });

async function run() {
  try {
    await client.connect();

    const database = client.db('justi');
    const collection = database.collection('justificaciones');

    // await collection.deleteMany({});

    const result = await collection.insertMany(content)
    console.log(result.insertedCount);
  
    // await collection.updateMany(
    //   { "UPDATED_AT": { "$type": "string" } },
    //   [{
    //     "$set": {
    //       "UPDATED_AT": { "$toDate": "$UPDATED_AT" },
    //       "FEC_SOL": { "$toDate": "$FEC_SOL" }
    //     }
    //   }]
    // );  

  } finally {
    // Ensures that the client will close when you finish/error
    await client.close();
  }
}

run().catch(console.dir);