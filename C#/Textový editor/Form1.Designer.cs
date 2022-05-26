namespace Textovy_editor
{
    partial class Form1
    {

        private System.ComponentModel.IContainer components = null;

        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }


        private void InitializeComponent()
        {
            this.textBox1 = new System.Windows.Forms.TextBox();
            this.button_tucne = new System.Windows.Forms.Button();
            this.button_kurziva = new System.Windows.Forms.Button();
            this.button_namala = new System.Windows.Forms.Button();
            this.button_navelka = new System.Windows.Forms.Button();
            this.vyber_velikosti = new System.Windows.Forms.NumericUpDown();
            ((System.ComponentModel.ISupportInitialize)(this.vyber_velikosti)).BeginInit();
            this.SuspendLayout();
            // 
            // textBox1
            // 
            this.textBox1.BackColor = System.Drawing.SystemColors.Control;
            this.textBox1.BorderStyle = System.Windows.Forms.BorderStyle.None;
            this.textBox1.Location = new System.Drawing.Point(0, 44);
            this.textBox1.Multiline = true;
            this.textBox1.Name = "textBox1";
            this.textBox1.Size = new System.Drawing.Size(805, 602);
            this.textBox1.TabIndex = 0;

            this.button_tucne.BackColor = System.Drawing.Color.LightGray;
            this.button_tucne.Font = new System.Drawing.Font("Segoe UI", 12F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point);
            this.button_tucne.Location = new System.Drawing.Point(12, 9);
            this.button_tucne.Name = "button_tucne";
            this.button_tucne.Size = new System.Drawing.Size(52, 29);
            this.button_tucne.TabIndex = 1;
            this.button_tucne.Text = "B";
            this.button_tucne.UseVisualStyleBackColor = false;
            this.button_tucne.Click += new System.EventHandler(this.button_tucne_Click);

            this.button_kurziva.BackColor = System.Drawing.Color.LightGray;
            this.button_kurziva.Font = new System.Drawing.Font("Segoe UI", 12F, System.Drawing.FontStyle.Italic, System.Drawing.GraphicsUnit.Point);
            this.button_kurziva.Location = new System.Drawing.Point(70, 9);
            this.button_kurziva.Name = "button_kurziva";
            this.button_kurziva.Size = new System.Drawing.Size(52, 29);
            this.button_kurziva.TabIndex = 1;
            this.button_kurziva.Text = "I";
            this.button_kurziva.UseVisualStyleBackColor = false;
            this.button_kurziva.Click += new System.EventHandler(this.button_kurziva_Click);

            this.button_namala.BackColor = System.Drawing.Color.LightGray;
            this.button_namala.Font = new System.Drawing.Font("Segoe UI", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point);
            this.button_namala.Location = new System.Drawing.Point(128, 9);
            this.button_namala.Name = "button_namala";
            this.button_namala.Size = new System.Drawing.Size(52, 29);
            this.button_namala.TabIndex = 1;
            this.button_namala.Text = "A-a";
            this.button_namala.UseVisualStyleBackColor = false;
            this.button_namala.Click += new System.EventHandler(this.button_namala_Click);

            this.button_navelka.BackColor = System.Drawing.Color.LightGray;
            this.button_navelka.Font = new System.Drawing.Font("Segoe UI", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point);
            this.button_navelka.Location = new System.Drawing.Point(186, 9);
            this.button_navelka.Name = "button_navelka";
            this.button_navelka.Size = new System.Drawing.Size(52, 29);
            this.button_navelka.TabIndex = 1;
            this.button_navelka.Text = "a-A";
            this.button_navelka.UseVisualStyleBackColor = false;
            this.button_navelka.Click += new System.EventHandler(this.button_navelka_Click);

            this.vyber_velikosti.Font = new System.Drawing.Font("Segoe UI", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point);
            this.vyber_velikosti.Location = new System.Drawing.Point(244, 9);
            this.vyber_velikosti.Name = "vyber_velikosti";
            this.vyber_velikosti.Size = new System.Drawing.Size(65, 29);
            this.vyber_velikosti.TabIndex = 2;
            this.vyber_velikosti.Value = new decimal(new int[] {
            12,
            0,
            0,
            0});
            this.vyber_velikosti.ValueChanged += new System.EventHandler(this.vyber_velikosti_ValueChanged);

            this.AutoScaleDimensions = new System.Drawing.SizeF(7F, 15F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.AutoValidate = System.Windows.Forms.AutoValidate.Disable;
            this.BackColor = System.Drawing.SystemColors.GradientInactiveCaption;
            this.ClientSize = new System.Drawing.Size(794, 640);
            this.Controls.Add(this.vyber_velikosti);
            this.Controls.Add(this.button_navelka);
            this.Controls.Add(this.button_namala);
            this.Controls.Add(this.button_kurziva);
            this.Controls.Add(this.button_tucne);
            this.Controls.Add(this.textBox1);
            this.MaximizeBox = false;
            this.MaximumSize = new System.Drawing.Size(810, 679);
            this.Name = "Form1";
            this.Text = "Textový editor";
            ((System.ComponentModel.ISupportInitialize)(this.vyber_velikosti)).EndInit();
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.TextBox textBox1;
        private System.Windows.Forms.Button button_tucne;
        private System.Windows.Forms.Button button_kurziva;
        private System.Windows.Forms.Button button_namala;
        private System.Windows.Forms.Button button_navelka;
        private System.Windows.Forms.NumericUpDown vyber_velikosti;
    }
}

