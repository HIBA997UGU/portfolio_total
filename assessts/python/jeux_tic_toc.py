import tkinter as tk
from tkinter import messagebox
from random import randrange

class TicTacToe:
    def __init__(self, root):
        self.root = root
        self.root.title("Tic Tac Toe")
        self.current_player = 'O'
        self.winner = None
        self.board = self.init_board()
        
        # Menu de démarrage
        self.start_frame = tk.Frame(root)
        self.start_frame.pack(pady=50)
        
        tk.Label(self.start_frame, text="Welcome to Tic Tac Toe!", font=('Arial', 16)).pack(pady=10)
        tk.Button(self.start_frame, text="Start Game", command=self.start_game, font=('Arial', 12)).pack(pady=5)
        tk.Button(self.start_frame, text="Quit", command=root.quit, font=('Arial', 12)).pack(pady=5)
        
        # Frame pour le plateau de jeu (caché au début)
        self.game_frame = tk.Frame(root)
        self.buttons = [[None for _ in range(3)] for _ in range(3)]
        
        for row in range(3):
            for col in range(3):
                self.buttons[row][col] = tk.Button(
                    self.game_frame, 
                    text='', 
                    font=('Arial', 24), 
                    width=5, 
                    height=2,
                    command=lambda r=row, c=col: self.on_button_click(r, c)
                )
                self.buttons[row][col].grid(row=row, column=col, padx=5, pady=5)
    
    def init_board(self):
        board = [[1, 2, 3], [4, 'X', 6], [7, 8, 9]]
        self.current_player = 'O'
        self.winner = None
        return board
    
    def start_game(self):
        self.start_frame.pack_forget()
        self.game_frame.pack(pady=20)
        self.board = self.init_board()
        self.update_buttons()
    
    def update_buttons(self):
        for row in range(3):
            for col in range(3):
                value = self.board[row][col]
                self.buttons[row][col]['text'] = value if value in ['X', 'O'] else ''
                self.buttons[row][col]['state'] = 'normal' if value not in ['X', 'O'] else 'disabled'
    
    def on_button_click(self, row, col):
        if self.board[row][col] in ['X', 'O']:
            return
            
        # Joueur humain joue
        self.board[row][col] = 'O'
        self.update_buttons()
        
        # Vérifier victoire
        if self.check_winner('O'):
            self.game_over('O')
            return
        
        # Vérifier match nul
        if len(self.free_fields()) == 0:
            self.game_over(None)
            return
            
        # Tour de l'ordinateur
        self.root.after(500, self.computer_move)
    
    def computer_move(self):
        free_squares = self.free_fields()
        if free_squares:
            row, col = free_squares[randrange(len(free_squares))]
            self.board[row][col] = 'X'
            self.update_buttons()
            
            # Vérifier victoire
            if self.check_winner('X'):
                self.game_over('X')
            elif len(self.free_fields()) == 0:
                self.game_over(None)
    
    def free_fields(self):
        free_squares = []
        for row in range(3):
            for col in range(3):
                if self.board[row][col] not in ['O', 'X']:
                    free_squares.append((row, col))
        return free_squares
    
    def check_winner(self, sign):
        # Vérifier les lignes
        for row in range(3):
            if all(self.board[row][col] == sign for col in range(3)):
                return True
        
        # Vérifier les colonnes
        for col in range(3):
            if all(self.board[row][col] == sign for row in range(3)):
                return True
        
        # Vérifier les diagonales
        if all(self.board[i][i] == sign for i in range(3)) or \
           all(self.board[i][2-i] == sign for i in range(3)):
            return True
        
        return False
    
    def game_over(self, winner):
        for row in range(3):
            for col in range(3):
                self.buttons[row][col]['state'] = 'disabled'
        
        if winner:
            messagebox.showinfo("Game Over", f"Player {winner} won the game!")
        else:
            messagebox.showinfo("Game Over", "It's a tie!")
        
        self.game_frame.pack_forget()
        self.start_frame.pack(pady=50)

if __name__ == "__main__":
    root = tk.Tk()
    game = TicTacToe(root)
    root.mainloop()