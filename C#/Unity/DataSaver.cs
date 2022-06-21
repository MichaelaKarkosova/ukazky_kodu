using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using System;
using System.Collections;
using System.Linq;
using System.Security.Cryptography;
using System.Text;
using System.IO;
using System.Web;
using System;
using System.Runtime.Serialization.Formatters.Binary;
using System.IO;

using CI.QuickSave.Core.Storage;

namespace DataSaver {
    [Serializable]
    class CarData {
        public string code;
        public bool owned;
        public float fuel;

        public CarData(string code,bool owned,float fuel) {
            this.code = code;
            this.owned = owned;
            this.fuel = fuel;
        }
    }

    [Serializable]
    class CarsData {


        public CarData[] cars;
        public string? checksum;
        public int? fuel;
        public int balance;
        public String spz;
    }

    /********** Auta => "entita" auta a "kolekce" aut *********/
    [Serializable]
    class Car {
        public string name;
        public string code;
        public int price;
        public bool owned;
        public float fuel;
        public Car(string name,string code,int price,bool owned,float fuel) {
            this.name = name;
            this.code = code;
            this.price = price;
            this.fuel = fuel;
            this.owned = owned;
        }
    }
    [Serializable]
    class Cars {
        public static CarsDatabase cardb = new CarsDatabase();
        /** @var Car[] */
        private Car[] cars;
        public int balance;
        public String spz;

        private Cars(Car[] cars) {
            this.cars = cars;
        }

        //načíst všechna auta
        public static Cars init() {

            Car[] allcars = {new Car("Tier 1 car","Tier1car",0,true,100),
                    new Car("Tier 2 car","Tier2car",20000,false,100),
                    new Car("Tier 3 car","Tier3car",50000,false,100),
                    new Car("Tier 4 car","Tier4car",80000,false,100),
                    new Car("Tier 5 car","Tier5car",130000,false,100),
                    new Car("Tier 6 car","Tier6car",180000,false,100),
                    new Car("Tier 7 car","Tier7car",250000,false,100),
                    new Car("Tier 8 car","Tier8car",400000,false,100)
        };
            return new Cars(allcars);
        }
        public Car[] all() {
            return this.cars;
        }
        public Car? get(string code) {
            foreach (Car car in this.all()) {
                if (car.code == code) {
                    return car;
                }

            }
            return null;
        }
        /********** Uložiště aut *********/
    }
    [Serializable]
    class CarsDatabase {
        public String DATABASE_FILE = Application.persistentDataPath + "/cars";
        private String CHECKSUM_SALT = "ecinvcnwoivnowcnowefnvvR434RFiegnf";
        public CarsDatabase() {
        }

        public void save(Cars cars) {
            try {
                // vytvořím data pro JSON, která obsahují údaje o autech. Stačí ti si ukládat jestli hráč dané auto vlastní, nic víc, zbytek jsou "statická" data.

                CarsData carsData = new CarsData();
                carsData.cars = cars.all().Select(car => new CarData(car.code,car.owned,car.fuel)).ToArray();
                carsData.checksum = null;
                carsData.balance = 100000;
                String spz = "Car-Master";
                carsData.spz = spz;

                String json = JsonUtility.ToJson(carsData,true); ;


                String checksum = sha256_hash(json + CHECKSUM_SALT);

                // do payloadu si přidám checksum
                int fuel = 1000;
                carsData.checksum = checksum;
                carsData.fuel = fuel;
                Debug.Log("Carsdata checksum: " + carsData.checksum);
                Debug.Log("Carsdata cars: " + carsData.cars);
                try {
                    BinaryFormatter formatter = new BinaryFormatter();
                    FileStream file = File.Create(this.DATABASE_FILE);
                    formatter.Serialize(file,carsData);
                    file.Close();
                }
                catch (Exception e) {
                    Debug.Log("Chyba při vytváření souboru!");
                    Debug.Log(e);

                }
                if (File.Exists(DATABASE_FILE)) {
                    Debug.Log("File exists");
                }
                else {
                    Debug.Log("File doesn't exists");
                }
            }
            catch (Exception e) {
                Debug.Log("Chyba");
                Debug.Log(e);
            }

        }
        //načíst data
        public Cars load() {
            Cars cars = Cars.init();

            if (!File.Exists(this.DATABASE_FILE)) {
                return cars;
            }
            try {
                BinaryFormatter formatter = new BinaryFormatter();
                FileStream file = File.Open(this.DATABASE_FILE,FileMode.Open);
                CarsData carsData = (CarsData)formatter.Deserialize(file);
                file.Close();

                String checksum = carsData.checksum;
                carsData.checksum = null;
                carsData.balance = carsData.balance;

                String json = JsonUtility.ToJson(carsData,true);
                String checksumVerify = sha256_hash(json + CHECKSUM_SALT);

                if (checksum != checksumVerify) {
                    Debug.Log("Content edited");
                    throw new Exception("Content error");
                }

                foreach (CarData carData in carsData.cars) {
                    Car? car = cars.get(carData.code);

                    if (null == car) {
                        continue;
                    }

                    car.owned = carData.owned;
                    car.fuel = carData.fuel;

                }
            }
            //pokud jsou poškozená data v binaru
            catch (Exception e) {
                Debug.Log("Content edited, binary bad: ");
                throw new Exception("Content error");
            }
            return cars;
        }

        static String sha256_hash(String value) {
            StringBuilder Sb = new StringBuilder();

            using (SHA256 hash = SHA256Managed.Create()) {
                Encoding enc = Encoding.UTF8;
                Byte[] result = hash.ComputeHash(enc.GetBytes(value));

                foreach (Byte b in result)
                    Sb.Append(b.ToString("x2"));
            }

            return Sb.ToString();
        }
    }

    class TestUseCase2 {
        public void run() {
            CarsDatabase database = new CarsDatabase();
            //načíst a uložit auta
            try {
                Cars cars = database.load();
                database.save(cars);
            }
            catch (Exception e) {
                throw new Exception("Error while loading game data. Contact developer. Error code: 502");
                Debug.Log(e);
            }
        }
    }


    public class DataSaver :MonoBehaviour {
        void Start() {
            new TestUseCase2().run();
        }
    }
}
