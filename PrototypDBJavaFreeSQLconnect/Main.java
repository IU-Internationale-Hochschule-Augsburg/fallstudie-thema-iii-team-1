import java.sql.SQLException;
import java.util.Scanner;

public class Main {
    public static void main(String[] args) throws SQLException {

        Scanner scan = new Scanner(System.in);
        JDBC test = new JDBC();

        int eingabeInt1;
        int eingabeInt2;
        int eingabeInt3;
        String eingabeStr1;
        String eingabeStr2;
        String eingabeStr3;

        boolean aktiv = true;

        while (aktiv) {

            System.out.println();
            System.out.println("Was möchten Sie tun? Bitte die entsprechende Nummer eingeben.");
            System.out.println("Buchung erstellen [1], Buchungsdetails ausgeben [2], Buchung löschen [3], Alle Buchungen anzeigen [4], Buchung suchen [5], Programm beenden [6]");
            short abfrage = scan.nextShort();

            switch (abfrage) {
                case 1:
                    System.out.println("values eingeben");
                    System.out.println("name eingeben");
                    scan.nextLine();
                    eingabeStr1 = scan.nextLine();
                    System.out.println("datum eingeben");
                    eingabeStr2 = scan.nextLine();
                    System.out.println("anzahl eingeben");
                    eingabeInt1 = scan.nextInt();
                    System.out.print("Die folgenden Tische sind frei: ");
                    for (int k: test.pruefenObFrei(eingabeStr2)) {
                        System.out.print("Tisch "+k+" ");
                    }
                    System.out.println();
                    System.out.println("idtisch eingeben");
                    eingabeInt2 = scan.nextInt();
                    if (!(test.pruefenObFrei(eingabeStr2).contains(eingabeInt2))) {
                        System.out.println("Tisch nicht frei!");
                        continue;
                    }
                    System.out.println("idmit eingeben");
                    eingabeInt3 = scan.nextInt();
                    System.out.println("kommentar eingeben");
                    scan.nextLine();
                    eingabeStr3 = scan.nextLine();
                    test.einfuegen(eingabeInt1, eingabeInt2, eingabeInt3, eingabeStr1, eingabeStr2, eingabeStr3);
                    break;
                case 2:
                    System.out.print("Bitte Buchungs ID eingeben: ");
                    eingabeInt1 = scan.nextInt();
                    test.abfragen(eingabeInt1);
                    break;
                case 3:
                    System.out.println("Bitte Buchungs ID angeben");
                    eingabeInt1 = scan.nextInt();
                    test.loeschen(eingabeInt1);
                    break;
                case 4:
                    test.anzeigenAlles();
                    break;
                case 5:
                    System.out.println("Bitte Namen eingeben");
                    scan.nextLine();
                    test.suchen(scan.nextLine());
                    break;
                case 6:
                    aktiv=false;
                    test.trennen();
                    continue;
                default:
                    System.out.println("Ungültige Eingabe");
                    break;
            }
        }
        scan.close();
    }
}