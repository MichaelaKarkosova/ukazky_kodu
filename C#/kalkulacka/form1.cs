using Microsoft.VisualBasic.CompilerServices;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace kalkulacka_po_netu
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();

        }

        private void buttonCislo2_Click(object sender, EventArgs e)
        {

        }

        private void ButtonsCisla_Click(object sender, EventArgs e)
        {
            Button cislice = sender as Button;
            
            if (labelDisplay1.Text == "0")
            {

                labelDisplay1.Text = cislice.Text;

            }
            else if (labelDisplay1.Text != "0")
            {
                labelDisplay1.Text = labelDisplay1.Text + cislice.Text;
            }



            else
            {


            }
            if (ZobrazenVysledek.Text == "ANO")
            {
                labelDisplay1.Text = cislice.Text;
                ZobrazenVysledek.Text = "NE";
            }
        }

        private void ButtonC_click(object sender, EventArgs e)
        {

            labelDisplay1.Text = "0";
            labelDisplay2.Text = "0";
            PomocneCislo1.Text = "00";
            PosledniVysledek.Text = "0";
            stisknuto.Text = "0";
            ZobrazenVysledek.Text = "NE";
            PosledniVysledek.Text = "0";
        }

        private void ButtonCE_click(object sender, EventArgs e)
        {
            labelDisplay1.Text = "0";

        }

        private void ButtonsOperace_click(object sender, EventArgs e)
        {
            Button operace = sender as Button;
            stisknuto.Text = operace.Text;
            string posledni = labelDisplay2.Text.Substring(labelDisplay2.Text.Length - 1);
            if (posledni != stisknuto.Text)
            {
                stisknuto.Text = posledni;

            }
            if (labelDisplay1.Text != "0")
            {
                if (labelDisplay2.Text == "0")
                {
                    labelDisplay2.Text = Convert.ToDouble(labelDisplay1.Text.ToString().Trim()) + operace.Text;
                    PomocneCislo1.Text = labelDisplay1.Text;
                    labelDisplay1.Text = "0";


                }
                else
                {
                    if (labelDisplay2.Text.Contains("+") || labelDisplay2.Text.Contains("-") || labelDisplay2.Text.Contains("/") || labelDisplay2.Text.Contains("*"))
                    {
                        string kekontrole = labelDisplay2.Text + labelDisplay1.Text + operace.Text;


                        {

                            labelDisplay2.Text = labelDisplay2.Text + Convert.ToDouble(labelDisplay1.Text.ToString().Trim()) + operace.Text;


                            if (PosledniVysledek.Text != "0")
                            {

                                if (stisknuto.Text == "+")
                                {
                                    double vysledek = double.Parse(PosledniVysledek.Text) + double.Parse(labelDisplay1.Text);

                                    labelDisplay1.Text = "0";
                                    labelDisplay1.Text = vysledek.ToString();
                                    PosledniVysledek.Text = vysledek.ToString();
                                    ZobrazenVysledek.Text = "ANO";
                                }
                                else if (stisknuto.Text == "-")
                                {
                                    double vysledek = double.Parse(PosledniVysledek.Text) - double.Parse(labelDisplay1.Text);

                                    labelDisplay1.Text = "0";
                                    labelDisplay1.Text = vysledek.ToString();
                                    PosledniVysledek.Text = vysledek.ToString();
                                    ZobrazenVysledek.Text = "ANO";
                                }
                                else if (stisknuto.Text == "*")
                                {
                                    double vysledek = double.Parse(PosledniVysledek.Text) * double.Parse(labelDisplay1.Text);

                                    labelDisplay1.Text = "0";
                                    labelDisplay1.Text = vysledek.ToString();
                                    PosledniVysledek.Text = vysledek.ToString();
                                    ZobrazenVysledek.Text = "ANO";
                                }
                                else if (stisknuto.Text == "/")
                                {
                                    double vysledek = double.Parse(PosledniVysledek.Text) / double.Parse(labelDisplay1.Text);

                                    labelDisplay1.Text = "0";
                                    labelDisplay1.Text = vysledek.ToString();
                                    PosledniVysledek.Text = vysledek.ToString();
                                    ZobrazenVysledek.Text = "ANO";
                                }
                            }
                            else
                            {
                                if (stisknuto.Text == "+")
                                {
                                    double vysledek = double.Parse(PomocneCislo1.Text) + double.Parse(labelDisplay1.Text);

                                    labelDisplay1.Text = "0";
                                    labelDisplay1.Text = vysledek.ToString();
                                    PomocneCislo1.Text = vysledek.ToString();
                                    ZobrazenVysledek.Text = "ANO";
                                }
                                else if (stisknuto.Text == "-")
                                {
                                    double vysledek = double.Parse(PomocneCislo1.Text) - double.Parse(labelDisplay1.Text);

                                    labelDisplay1.Text = "0";
                                    labelDisplay1.Text = vysledek.ToString();
                                    PomocneCislo1.Text = vysledek.ToString();
                                    ZobrazenVysledek.Text = "ANO";
                                }
                                else if (stisknuto.Text == "*")
                                {
                                    double vysledek = double.Parse(PomocneCislo1.Text) * double.Parse(labelDisplay1.Text);

                                    labelDisplay1.Text = "0";
                                    labelDisplay1.Text = vysledek.ToString();
                                    PomocneCislo1.Text = vysledek.ToString();
                                    ZobrazenVysledek.Text = "ANO";
                                }
                                else if (stisknuto.Text == "/")
                                {
                                    double vysledek = double.Parse(PomocneCislo1.Text) / double.Parse(labelDisplay1.Text);

                                    labelDisplay1.Text = "0";
                                    labelDisplay1.Text = vysledek.ToString();
                                    PomocneCislo1.Text = vysledek.ToString();
                                    ZobrazenVysledek.Text = "ANO";
                                }
                            }

                        }
                    }
                    else
                    {
                        labelDisplay2.Text = labelDisplay2.Text + operace.Text + labelDisplay1.Text;
                        labelDisplay1.Text = "0";
                        stisknuto.Text = operace.Text;
                        ZobrazenVysledek.Text = "NE";
                    }
                }
            }

            else
            {


            }



        }


        private void ButtonsRovnaSe_click(object sender, EventArgs e)
        {
            string posledni = labelDisplay2.Text.Substring(labelDisplay2.Text.Length - 1);
       
            if (posledni == "+")
            {
                if (PosledniVysledek.Text != "0")
                {
                    double vysledek = double.Parse(PosledniVysledek.Text) + double.Parse(labelDisplay1.Text);
                    labelDisplay1.Text = vysledek.ToString();
                   labelDisplay2.Text = "0";
                }
                else
                {
                    double vysledek = double.Parse(PomocneCislo1.Text) + double.Parse(labelDisplay1.Text);
                    labelDisplay1.Text = vysledek.ToString();
                   labelDisplay2.Text = "0";
                }
            }
           else if (posledni == "-")
            {
                if (PosledniVysledek.Text != "0")
                {
                    double vysledek = double.Parse(PosledniVysledek.Text) - double.Parse(labelDisplay1.Text);
                    labelDisplay1.Text = vysledek.ToString();
                    labelDisplay2.Text = "0";
                }
                else
                {
                    double vysledek = double.Parse(PomocneCislo1.Text) -double.Parse(labelDisplay1.Text);
                    labelDisplay1.Text = vysledek.ToString();
                    labelDisplay2.Text = "0";
                }

            }
            else if (posledni == "*")
            {
                if (PosledniVysledek.Text != "0")
                {
                    double vysledek = double.Parse(PosledniVysledek.Text) * double.Parse(labelDisplay1.Text);
                    labelDisplay1.Text = vysledek.ToString();
                    labelDisplay2.Text = "0";
                }
                else
                {
                    double vysledek = double.Parse(PomocneCislo1.Text) * double.Parse(labelDisplay1.Text);
                    labelDisplay1.Text = vysledek.ToString();
                    labelDisplay2.Text = "0";
                }
            }
            else if (posledni == "/")
            {
                if (PosledniVysledek.Text != "0")
                {
                    double vysledek = double.Parse(PosledniVysledek.Text) / double.Parse(labelDisplay1.Text);
                    labelDisplay1.Text = vysledek.ToString();
                    labelDisplay2.Text = "0";
                }
                else
                {
                    double vysledek = double.Parse(PomocneCislo1.Text) / double.Parse(labelDisplay1.Text);
                    labelDisplay1.Text = vysledek.ToString();
                    labelDisplay2.Text = "0";
                }
            }

        }

        private void labelDisplay2_Click(object sender, EventArgs e)
        {

        }

        private void labelDisplay1_Click(object sender, EventArgs e)
        {

        }

        private void buttonDesetinnaCarka_Click(object sender, EventArgs e)
        {
            string posledni = labelDisplay1.Text.Substring(labelDisplay1.Text.Length - 1);
            if (posledni != ",")
            {
                labelDisplay1.Text = labelDisplay1.Text + ",";
               double novecislo = Convert.ToDouble(labelDisplay1.Text.ToString().Trim());
            }
        }
    }
}
