using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
using UnityEngine.EventSystems;
using System;
namespace SpaceGraphicsToolkit {

    public class openChat :MonoBehaviour {
        public InputField mainInputField;
         public string submitKey = "Submit";
        public void Start() {
            //Adds a listener to the main input field and invokes a method when the value changes.
            mainInputField.onValueChanged.AddListener(delegate { ValueChangeCheck(); });

        }


        // Start is called before the first frame update
        public void ValueChangeCheck() {
            Debug.Log("Value Changed");
            GameObject.Find("Main Camera").GetComponent<SgtCameraMove>().enabled = false;
            GameObject.Find("Camera Pivot").GetComponent<SgtCameraLook>().RollSpeed = 0;
            RectTransform rt = GameObject.Find("TextBig").GetComponent<RectTransform>();
            rt.sizeDelta = new Vector2(250,250);
            rt = GameObject.Find("TextChat").GetComponent<RectTransform>();
            rt.sizeDelta = new Vector2(250,250);
            RectTransform rtt = GameObject.Find("PlanetInfo").GetComponent<RectTransform>();
            rtt.sizeDelta = new Vector2(0,0);
            if (Input.GetKeyDown(KeyCode.Return)) {

               string chatmessage= GameObject.Find("InputField").GetComponent<InputField>().text;

                string oldchat = GameObject.Find("TextChat").GetComponent<Text>().text;
                if (chatmessage != "") {

                    Debug.Log("Oldchat: " + oldchat + ", chatmessage: " + chatmessage);
                    GameObject.Find("TextChat").GetComponent<Text>().text = oldchat + " \n Player: " + chatmessage;
                    Debug.Log("Player: " + oldchat + chatmessage);
                    GameObject.Find("InputField").GetComponent<InputField>().text = "";
                }

            }
            }

        public void Update() {
            if (Input.GetKeyDown(KeyCode.W)) {
            }
            else if (EventSystem.current.currentSelectedGameObject == null && GameObject.Find("Main Camera").GetComponent<SgtCameraMove>().enabled == false) {
                GameObject.Find("Main Camera").GetComponent<SgtCameraMove>().enabled = true;
                GameObject.Find("Camera Pivot").GetComponent<SgtCameraLook>().RollSpeed = 50;
                RectTransform rt = GameObject.Find("TextBig").GetComponent<RectTransform>();
                rt.sizeDelta = new Vector2(0,0);
                 rt = GameObject.Find("TextChat").GetComponent<RectTransform>();
                rt.sizeDelta = new Vector2(0,0);
            }
        }
        void OnSubmit(string line) {
        }
        
    }
}
