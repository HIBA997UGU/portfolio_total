from tkinter import *

root = Tk()
root.title("Simple Calculator")
root.geometry("320x420")
root.resizable(width=0, height=0)
root.configure(bg="black")


def click(char):
    e.insert(END, str(char))


def clear():
    e.delete(0, END)


def equal():
    try:
        result = eval(e.get())
        clear()
        e.insert(END, str(result))
    except:
        clear()
        e.insert(END, "Erreur")


e = Entry(root, bd=10, width=25, font=("Arial", 21), bg="light grey", justify=RIGHT)
e.pack(pady=20)


buttons = [
    ('7', 10, 90), ('8', 90, 90), ('9', 170, 90), ('/', 250, 90),
    ('4', 10, 160), ('5', 90, 160), ('6', 170, 160), ('*', 250, 160),
    ('1', 10, 230), ('2', 90, 230), ('3', 170, 230), ('-', 250, 230),
    ('0', 10, 300), ('.', 90, 300), ('C', 170, 300), ('+', 250, 300),
]


for (text, x, y) in buttons:
    if text == 'C':
        btn = Button(root, text=text, font=("Arial", 19, "bold"), bg="crimson", fg="white",
                     bd=5, command=clear)
    else:
        btn = Button(root, text=text, font=("Arial", 19, "bold"), bg="grey",
                     bd=5, command=lambda char=text: click(char))
    btn.place(x=x, y=y, width=70, height=60)


btn_equal = Button(root, text='=', font=("Arial", 19, "bold"), bg="khaki", bd=5, command=equal)
btn_equal.place(x=10, y=370, width=310, height=50)

root.mainloop()