isi_proiect
===========

isiproject

This is a web based timesheet manager, a project for school, where the employees can write their monthly timesheet, which means that in every working day he has to write his daily sheet by adding his tasks in the application.

There is a database for 5 types of users:
* employee
* department manager
* division manager
* director
* admin

We used XAMPP, which is an Apache distribution containing MySQL and PHP. This github branch (folder) represents the htdocs folder added at install of XAMPP. 

install: http://www.apachefriends.org/en/xampp-windows.html

(link to download: http://www.apachefriends.org/download.php?xampp-win32-1.8.2-2-VC9-installer.exe)

* install XAMPP
* toate fișierele sursă se pun în folderul XAMPP\htdocs

DONE:
- pct a, b, d, e : ""
- pct a : de afisat numele angajatului (sau ID)
- functionalitate buton "Adauga proiect" de la seful de departament
- pct c : de scos numele angajatului (verificat group by project)
- raportele c, d in excel
- fiecare raport trebuie sa aiba si o versiune excel disponibila pt download
- directorul trebuie sa aiba acces la pct d) si e)
- adaugat numele angajatilor la inregistrare
- adaugat nume si prenume angajati la inregist
- pct f (doar la director)
- seful de departament poate adauga sau sterge angajatii
- OPEN / SUBMIT / APPROVE / REJECT timesheet
- la final unei luni, timesheetul nu mai poate fi editat
- baza de date cu activitati uzuale (userul isi alege o activitate dintr-o coloana noua drop down list)
- popularea bazei de date (de trimis login.sql)
- functionalitate buton "Verifica rapoarte" ( director + sef div + sef dept )
- notificare prin email (de facut submit)
- pct c : sortare asc/desc ale rezultatelor in functie de ore
- documentul + prezentare in pptx 
- audit (loguri cu nivele)
- CSS / design / frontend
- la rapoartele a,b,e de modificat numele angajatilor din angajat1, angajat2 in numele lor efectiv

* https://asana.com/
