public class Main {
    public static void main(String[] args) {

        Buchung[][] buchungen = new Buchung[7][24];

        Buchung test = new Buchung("huber", 4, 5, 2, true, "geschäftsessen");
        buchungen[0][1] = test;
        Buchung test1 = new Buchung("haber", 5, 2, 6, false, "geschäftsessen");
        buchungen[1][2] = test1;
        Buchung test2 = new Buchung("haber", 5, 2, 6, false, "geschäftsessen");
        buchungen[3][2] = test2;
        Buchung test3 = new Buchung("haber", 5, 2, 6, false, "geschäftsessen");
        buchungen[4][7] = test3;
        Buchung test4 = new Buchung("huber", 4, 5, 2, true, "geschäftsessen");
        buchungen[4][17] = test4;
        Buchung test5 = new Buchung("haber", 5, 2, 6, false, "geschäftsessen");
        buchungen[5][17] = test5;
        Buchung test6 = new Buchung("haber", 5, 2, 6, false, "geschäftsessen");
        buchungen[6][8] = test6;
        Buchung test7 = new Buchung("haber", 5, 2, 6, false, "geschäftsessen");
        buchungen[6][20] = test7;
        Buchung test8 = new Buchung("haber", 5, 2, 6, false, "geschäftsessen");
        buchungen[6][21] = test8;
        Buchung test9 = new Buchung("haber", 5, 2, 6, false, "geschäftsessen");
        buchungen[6][22] = test9;

        System.out.println();

        System.out.print("Uhrzeit: ");
        for (int i = 0; i < 10; i++) {
            System.out.print(" " + i + ":00 ");
        }
        for (int i = 10; i < 24; i++) {
            System.out.print(i + ":00 ");
        }
        System.out.println();
        for (int wochentag = 0; wochentag < buchungen.length; wochentag++) {
            System.out.print("Tag " + wochentag + ":   ");
            for (int uhrzeit = 0; uhrzeit < buchungen[wochentag].length; uhrzeit++) {
                if (buchungen[wochentag][uhrzeit] == null) {
                    System.out.print(" Frei ");
                } else {
                    if (buchungen[wochentag][uhrzeit].getBuchungsnummer() <10) {
                        System.out.print(" 000" + buchungen[wochentag][uhrzeit].getBuchungsnummer() + " ");
                    }
                    else if (buchungen[wochentag][uhrzeit].getBuchungsnummer() <100) {
                        System.out.print(" 00" + buchungen[wochentag][uhrzeit].getBuchungsnummer() + " ");
                    }
                    else  {
                        System.out.print(" 0" + buchungen[wochentag][uhrzeit].getBuchungsnummer() + " ");
                    }
                }
            }
            System.out.println();
        }
    }
}