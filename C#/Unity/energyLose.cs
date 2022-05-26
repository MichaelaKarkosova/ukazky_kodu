using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;

public class EnergyLose : MonoBehaviour
{
    // Start is called before the first frame update
    void Start()
    {
        StartCoroutine("DoCheck");
    }

    // Update is called once per frame
    void Update()
    {
        Debug.Log("Rychlost: " +GameObject.Find("RocketShip").GetComponent<Rigidbody>().velocity.magnitude);
    }

    IEnumerator DoCheck() {
        for (; ; ) {
            float newpalivo;
            float speed = GameObject.Find("RocketShip").GetComponent<Rigidbody>().velocity.magnitude;
    
            float palivo = speed * 0.08f;
            float oldpalivo;
            if (!GameObject.Find("RocketShip").GetComponent<CameraSwitcher>().photoenabled) {
                 oldpalivo = GameObject.Find("EnergyBar").GetComponent<ProgressBarPro>().Value*100;
                newpalivo = oldpalivo - palivo;
                GameObject.Find("EnergyBar").GetComponent<ProgressBarPro>().Value = newpalivo / 100;
            }
            else {
                oldpalivo = int.Parse(GameObject.Find("debugtext").GetComponent<Text>().text) * 100;
                newpalivo = oldpalivo - palivo;
                GameObject.Find("debugtext").GetComponent<Text>().text = (newpalivo / 100).ToString();
            }
            yield return new WaitForSeconds(3f);
        }
    }
}

