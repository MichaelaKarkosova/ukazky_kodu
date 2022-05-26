using UnityEngine;
using UnityEngine.AI;
using UnityEngine.UI;
using System.Collections;
using TMPro;

public class NPCController :MonoBehaviour {
    public float patrolTime = 15; 
    public float aggroRange = 10; 
    public Transform[] waypoints; 
    private Animator anim;
    public AnimationClip ItsAttack01;
    int index; 
    double speed, agentSpeed; 
    Transform player; 
    Transform volcano;
    Transform velociraptor; 
    Animator animator; 
    NavMeshAgent agent; 
    public int zdravihrace = 30;
    public double zdravihraceprocent = 100;
    private Animation animace;
    public TextMeshProUGUI bubbletext;
    public TextMeshProUGUI hpstat;
    public TextMeshProUGUI temperaturestat;
    public TextMeshProUGUI temperaturetext;
    public float thrust = 1.0f;
    public Rigidbody rb;
    public Image textbubble;
    public int deletedvalues = 0;
    public bool shown = false;
    public GameObject[] raptori;

void OnGUI() {

    }
    void Awake() {
            shown = false;
    
    RectTransform rt = GameObject.Find("textbubble").GetComponent<RectTransform>();
        rt.sizeDelta = new Vector2(0,0);

    
        string hpbar = "----------";
        bubbletext = GameObject.Find("Textinbubble").GetComponent<TextMeshProUGUI>();
        bubbletext.GetComponent<TextMeshProUGUI>().text = "";

    zdravihrace = 30;

        player = GameObject.FindGameObjectWithTag("Player").transform;
        animator = GetComponent<Animator>();
        agent = GetComponent<NavMeshAgent>();
        if (agent != null) { agentSpeed = agent.speed; }
        GameObject.CreatePrimitive(PrimitiveType.Sphere).transform.position = waypoints[index].position;
        index = Random.Range(0,waypoints.Length);
        InvokeRepeating("Tick",0,0.5f);
    if (waypoints.Length > 0) {
        InvokeRepeating("Patrol",0,patrolTime);
    }

    }
    void Patrol() {
        index = index == waypoints.Length - 1 ? 0 : index + 1;
    }

    void Tick() {
        player = GameObject.FindGameObjectWithTag("Player").transform;
        volcano = GameObject.Find("vnitreksopky").transform;
        double distancebetween = Vector3.Distance(player.position,volcano.position);
     

        if (distancebetween < 250 && distancebetween > 240) {
            temperaturestat = GameObject.Find("StatusTemperature").GetComponent<TextMeshProUGUI>();
            temperaturestat.GetComponent<TextMeshProUGUI>().text = "27ºC";
        }
        else if (distancebetween < 240 && distancebetween > 230) {
            temperaturestat = GameObject.Find("StatusTemperature").GetComponent<TextMeshProUGUI>();
            temperaturestat.GetComponent<TextMeshProUGUI>().text = "28ºC";

            StartCoroutine(waiter());


        }
        else if (distancebetween < 230 && distancebetween > 220) {
            temperaturestat = GameObject.Find("StatusTemperature").GetComponent<TextMeshProUGUI>();
            temperaturestat.GetComponent<TextMeshProUGUI>().text = "30ºC";

        }
        else if (distancebetween < 220 && distancebetween > 210) {
            temperaturestat = GameObject.Find("StatusTemperature").GetComponent<TextMeshProUGUI>();
            temperaturestat.GetComponent<TextMeshProUGUI>().text = "32ºC";
        }
        else if (distancebetween < 210 && distancebetween > 200) {
            temperaturestat = GameObject.Find("StatusTemperature").GetComponent<TextMeshProUGUI>();
            temperaturestat.GetComponent<TextMeshProUGUI>().text = "34ºC";
        }
        else if (distancebetween < 200 && distancebetween > 190) {
            temperaturestat = GameObject.Find("StatusTemperature").GetComponent<TextMeshProUGUI>();
            temperaturestat.GetComponent<TextMeshProUGUI>().text = "37ºC";
        }
        else if (distancebetween < 190 && distancebetween > 185) {
            temperaturestat = GameObject.Find("StatusTemperature").GetComponent<TextMeshProUGUI>();
            temperaturestat.GetComponent<TextMeshProUGUI>().text = "40ºC";
        }
        else if (distancebetween < 185 && distancebetween > 180) {
            temperaturestat = GameObject.Find("StatusTemperature").GetComponent<TextMeshProUGUI>();
            temperaturestat.GetComponent<TextMeshProUGUI>().text = "45ºC";
        }
        else if (distancebetween < 180 && distancebetween > 175) {
            temperaturestat = GameObject.Find("StatusTemperature").GetComponent<TextMeshProUGUI>();
            temperaturestat.GetComponent<TextMeshProUGUI>().text = "50ºC";
        }
        else if (distancebetween < 175 && distancebetween > 170) {
            temperaturestat = GameObject.Find("StatusTemperature").GetComponent<TextMeshProUGUI>();
            temperaturestat.GetComponent<TextMeshProUGUI>().text = "55ºC";
            zdravihrace = zdravihrace - 1;
            zdravihraceprocent = zdravihraceprocent - 3.3;
            double num = zdravihraceprocent;
            int i = (int)num;

            hpstat = GameObject.Find("StatusHP").GetComponent<TextMeshProUGUI>();

            hpstat.GetComponent<TextMeshProUGUI>().text = i + "% (" + zdravihrace + "/30)";
            temperaturetext = GameObject.Find("temperaturetext").GetComponent<TextMeshProUGUI>();
            temperaturetext.GetComponent<TextMeshProUGUI>().text = "Its too hot here! Go away";
        }
        else if (distancebetween < 170 && distancebetween > 165) {
            temperaturestat = GameObject.Find("StatusTemperature").GetComponent<TextMeshProUGUI>();
            temperaturestat.GetComponent<TextMeshProUGUI>().text = "60ºC";
            zdravihrace = zdravihrace - 1;

            zdravihraceprocent = zdravihraceprocent - 3.3;
            double num = zdravihraceprocent;
            int i = (int)num;
            hpstat = GameObject.Find("StatusHP").GetComponent<TextMeshProUGUI>();

            hpstat.GetComponent<TextMeshProUGUI>().text = i + "% (" + zdravihrace + "/30)";
            temperaturetext = GameObject.Find("temperaturetext").GetComponent<TextMeshProUGUI>();
            temperaturetext.GetComponent<TextMeshProUGUI>().text = "Its too hot here! Go away";
        }
        else if (distancebetween < 165 && distancebetween > 160) {
            temperaturestat = GameObject.Find("StatusTemperature").GetComponent<TextMeshProUGUI>();
            temperaturestat.GetComponent<TextMeshProUGUI>().text = "65ºC";
            zdravihrace = zdravihrace - 1;
            zdravihraceprocent = zdravihraceprocent - 3.3;
            double num = zdravihraceprocent;
            int i = (int)num;
            hpstat = GameObject.Find("StatusHP").GetComponent<TextMeshProUGUI>();
            hpstat.GetComponent<TextMeshProUGUI>().text = i + "% (" + zdravihrace + "/30)";
            temperaturetext = GameObject.Find("temperaturetext").GetComponent<TextMeshProUGUI>();
            temperaturetext.GetComponent<TextMeshProUGUI>().text = "Its too hot here! Go away";
        }
        else if (distancebetween < 160) {
            zdravihrace = zdravihrace - 1;
            zdravihraceprocent = zdravihraceprocent - 3.3;
            double num = zdravihraceprocent;
            int i = (int)num;
            hpstat = GameObject.Find("StatusHP").GetComponent<TextMeshProUGUI>();
            hpstat.GetComponent<TextMeshProUGUI>().text = i + "% (" + zdravihrace + "/30)";
            temperaturetext = GameObject.Find("temperaturetext").GetComponent<TextMeshProUGUI>();
            temperaturetext.GetComponent<TextMeshProUGUI>().text = "Its too hot here! Go away";

        }
        else if (distancebetween < 100) {
            zdravihrace = zdravihrace - 5;
            zdravihraceprocent = zdravihraceprocent - 16.65;
            double num = zdravihraceprocent;
            int i = (int)num;
            hpstat = GameObject.Find("StatusHP").GetComponent<TextMeshProUGUI>();
            hpstat.GetComponent<TextMeshProUGUI>().text = i + "% (" + zdravihrace + "/30)";
            temperaturetext = GameObject.Find("temperaturetext").GetComponent<TextMeshProUGUI>();
            temperaturetext.GetComponent<TextMeshProUGUI>().text = "Its too hot here! Go away";

        }
        else {
            temperaturestat = GameObject.Find("StatusTemperature").GetComponent<TextMeshProUGUI>();
            temperaturestat.GetComponent<TextMeshProUGUI>().text = "25ºC";
            temperaturetext = GameObject.Find("temperaturetext").GetComponent<TextMeshProUGUI>();
            temperaturetext.GetComponent<TextMeshProUGUI>().text = "";

        }
        string hpbar = "----------";
        animace = GetComponent<Animation>();
        anim = GetComponent<Animator>();
        agent.destination = waypoints[index].position;
        velociraptor = GameObject.FindGameObjectWithTag("Velociraptor").transform;
    
            double dist = Vector3.Distance(player.position,velociraptor.position);


        if (dist < 2.7f) {
            agent.speed = 0;
            anim.SetBool("ItsRunning",true);
            anim.SetBool("ItsWalking",false);
            anim.Play("Base Layer.attack01",0,0.6f);

            if (zdravihrace == 0) {
                zdravihrace = zdravihrace - 2;
             
                Application.Quit();



            }
            else {

                zdravihrace = zdravihrace - 2;
                zdravihraceprocent = zdravihraceprocent - 7;
                hpstat = GameObject.Find("StatusHP").GetComponent<TextMeshProUGUI>();
                double num = zdravihraceprocent;
                int i = (int)num;
                hpstat.GetComponent<TextMeshProUGUI>().text = i+ "% (" + zdravihrace + "/30)";

      
            }


        }
        else if (dist < 13) {
            agent.speed = 4;
            bubbletext = GameObject.Find("Textinbubble").GetComponent<TextMeshProUGUI>();
            bubbletext.GetComponent<TextMeshProUGUI>().text = "Escape! Run!";
            RectTransform rt = GameObject.Find("textbubble").GetComponent<RectTransform>();
            rt.sizeDelta = new Vector2(100,100.09f);

            agent.destination = player.position;


        }
        else if (dist < 16) {
            StartCoroutine(waiter2());



        }
        else {
            agent.speed = 2;
            anim.SetBool("ItsWalking",true);
            agent.destination = waypoints[index].position;
        }
        if (zdravihrace < 8) {
            RectTransform rt = GameObject.Find("bloody").GetComponent<RectTransform>();
            rt.sizeDelta = new Vector2(100,100.09f);
        }
        if (zdravihrace < 0) {
            RectTransform rt = GameObject.Find("deathscreen").GetComponent<RectTransform>();
            rt.sizeDelta = new Vector2(100,100.09f);
        }

    }
    void kousnuti() {



    }
    IEnumerator waiter() {


            bubbletext = GameObject.Find("Textinbubble").GetComponent<TextMeshProUGUI>();
            bubbletext.GetComponent<TextMeshProUGUI>().text = "Volcano is hot. If temperature is too large, you will take damage! Stay away";
            RectTransform rt = GameObject.Find("textbubble").GetComponent<RectTransform>();
            rt.sizeDelta = new Vector2(100,100.09f);
            yield return new WaitForSeconds(6);

            rt.sizeDelta = new Vector2(0,0);
            bubbletext.GetComponent<TextMeshProUGUI>().text = "";

    }

    IEnumerator waiter2() {


        bubbletext = GameObject.Find("Textinbubble").GetComponent<TextMeshProUGUI>();
        bubbletext.GetComponent<TextMeshProUGUI>().text = "Stay away from raptor. It's fast and dangerous hunter!";
        RectTransform rt = GameObject.Find("textbubble").GetComponent<RectTransform>();
        rt.sizeDelta = new Vector2(100,100.09f);
        yield return new WaitForSeconds(6);

        rt.sizeDelta = new Vector2(0,0);
        bubbletext.GetComponent<TextMeshProUGUI>().text = "";
    }
    }
