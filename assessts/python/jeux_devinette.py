import tkinter as tk
import random

class JeuDevinette:
    def __init__(self, master):
        self.master = master
        master.title("Jeu de devinette")
        
        self.nombre_a_deviner = random.randint(1, 100)
        self.essais = 0
        
        self.label = tk.Label(master, text="Devinez un nombre entre 1 et 100:")
        self.label.pack()
        
        self.entry = tk.Entry(master)
        self.entry.pack()
        
        self.button = tk.Button(master, text="Essayer", command=self.verifier)
        self.button.pack()
        
        self.resultat = tk.Label(master, text="")
        self.resultat.pack()
        
        self.rejouer_button = tk.Button(master, text="Rejouer", command=self.rejouer, state=tk.DISABLED)
        self.rejouer_button.pack()
    
    def verifier(self):
        try:
            guess = int(self.entry.get())
            self.essais += 1
            
            if guess < self.nombre_a_deviner:
                self.resultat.config(text="Trop bas! Essayez encore.")
            elif guess > self.nombre_a_deviner:
                self.resultat.config(text="Trop haut! Essayez encore.")
            else:
                self.resultat.config(text=f"Bravo! Vous avez trouvé en {self.essais} essais.")
                self.button.config(state=tk.DISABLED)
                self.rejouer_button.config(state=tk.NORMAL)
        except ValueError:
            self.resultat.config(text="Veuillez entrer un nombre valide!")
    
    def rejouer(self):
        self.nombre_a_deviner = random.randint(1, 100)
        self.essais = 0
        self.entry.delete(0, tk.END)
        self.resultat.config(text="")
        self.button.config(state=tk.NORMAL)
        self.rejouer_button.config(state=tk.DISABLED)

root = tk.Tk()
mon_jeu = JeuDevinette(root)
root.mainloop()