import java.util.Scanner;

public class Main {

    public static Buchung[][] buchungen = new Buchung[7][24];
    static Scanner scan = new Scanner(System.in);

    public static void main(String[] args) {

        boolean aktiv = true;

        while (aktiv) {

            System.out.println();
            System.out.println("Was möchten Sie tun? Bitte die entsprechende Nummer eingeben.");
            System.out.println("Buchung erstellen [1], Mitarbeiter einsehen [2], Buchungsdetails ausgeben [3], Buchung löschen [4], Alle Buchungen anzeigen [5], Programm beenden [6]");
            short abfrage = scan.nextShort();

            switch (abfrage) {
                case 1:
                    Main.buchungEintragen();
                    break;
                case 2:
                    break;
                case 3:
                    break;
                case 4:
                    buchungLoeschen();
                    break;
                case 5:
                    datenbankAnzeigen();
                    break;
                case 6:
                    aktiv=false;
                    continue;
                default:
                    System.out.println("Ungültige Eingabe");
                    break;
            }
        }
    }

    public static void buchungEintragen() {

        Buchung test2 = new Buchung();
        scan.nextLine();
        System.out.println("nachname eingeben");
        test2.setGastNachname(scan.nextLine());
        System.out.println("anzahl eingeben");
        test2.setAnzahlPersonen(scan.nextInt());
        System.out.println("tag eingeben (montag:1, dienstag:2 ... sonntag:7");
        test2.setWochentag(scan.nextInt());
        System.out.println("uhrzeit eingeben");
        test2.setUhrzeit(scan.nextInt());
        System.out.println("tisch eingeben");
        test2.setTisch_id(scan.nextInt());
        System.out.println("mitarbeiternummer eingeben");
        test2.setMitarbeiter_id(scan.nextInt());
        System.out.println("kinderstuhl true/false eingeben");
        test2.setKinderstuhl(scan.nextBoolean());
        scan.nextLine();
        System.out.println("kommentar eingeben");
        test2.setKommentar(scan.nextLine());

        buchungen[test2.getWochentag()-1][test2.getUhrzeit()] = test2;
    }


    public static void datenbankAnzeigen() {
        System.out.println();
        System.out.println("********* > Tag      mo    di    mi    do    fr    sa    so");
        System.out.println("v Uhrzeit ");
        System.out.println();

        for (int i = 0; i < 24; i++) {
            if (i < 10) {
                System.out.print(" " + i + ":00");
            } else {
                System.out.print(i + ":00");
            }
            System.out.print(" Uhr           ");
            for (int i1 = 0; i1 < 7; i1++) {
                if (buchungen[i1][i] == null) {
                    System.out.print(" Frei ");
                } else {
                    if (buchungen[i1][i].getBuchungsnummer() < 10) {
                        System.out.print(" 000" + buchungen[i1][i].getBuchungsnummer() + " ");
                    } else if (buchungen[i1][i].getBuchungsnummer() < 100) {
                        System.out.print(" 00" + buchungen[i1][i].getBuchungsnummer() + " ");
                    } else {
                        System.out.print(" 0" + buchungen[i1][i].getBuchungsnummer() + " ");
                    }
                }
            }
            System.out.println();
        }
    }


    public static void buchungLoeschen(){

        System.out.println("tag eingeben");
        int loeschenTag = scan.nextInt();
        System.out.println("uhrzeit eingeben");
        int loeschenUhrzeit = scan.nextInt();
        buchungen[loeschenTag-1][loeschenUhrzeit] = null;

    }

}