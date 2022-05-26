using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace Textovy_editor
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }


    private void button_tucne_Click(object sender, EventArgs e)
    {
        if (textBox1.Font.Style == FontStyle.Bold)
        {
                button_tucne.BackColor = System.Drawing.Color.LightGray;

                textBox1.Font = new Font(textBox1.Font, FontStyle.Regular);

        }
        else
        {
                button_tucne.BackColor = System.Drawing.Color.Gray;
                button_kurziva.BackColor = System.Drawing.Color.LightGray;

                textBox1.Font = new Font(textBox1.Font, FontStyle.Bold);
        }
    }

    private void button_kurziva_Click(object sender, EventArgs e)
    {
        if (textBox1.Font.Style == FontStyle.Italic)
        {
                button_kurziva.BackColor = System.Drawing.Color.LightGray;
                textBox1.Font = new Font(textBox1.Font, FontStyle.Regular);
        }
        else
        {
                button_kurziva.BackColor = System.Drawing.Color.Gray;
                button_tucne.BackColor = System.Drawing.Color.LightGray;
                textBox1.Font = new Font(textBox1.Font, FontStyle.Italic);
        }
    }

    private void button_navelka_Click(object sender, EventArgs e)
    {
        string text = textBox1.Text;
        text = text.ToUpper();
        textBox1.Text = text;
    }

    private void button_namala_Click(object sender, EventArgs e)
    {
        string text = textBox1.Text;
        text = text.ToLower();
        textBox1.Text = text;
    }

    private void textBox2_TextChanged(object sender, EventArgs e)
    {

    }

    private void vyber_velikosti_ValueChanged(object sender, EventArgs e)
    {
        string velikost = vyber_velikosti.Value.ToString();
        int velikoost = int.Parse(vyber_velikosti.Value.ToString());
        textBox1.Font = new Font(textBox1.Font.FontFamily, velikoost);

    }

    private void textBox1_TextChanged(object sender, EventArgs e)
    {

    }


    private void Form1_Load_1(object sender, EventArgs e)
    {

    }

    }
}
