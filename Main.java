public class Main {
    public static void main(String[] args) {

        Buchung[][] buchungen = new Buchung[7][24];

        Buchung test = new Buchung(Buchung.buchungszaehler, "huber", 4, 5, 2, true, "geschäftsessen");
        buchungen[0][1] = test;

        Buchung test1 = new Buchung(Buchung.buchungszaehler, "haber", 5, 2, 6, false, "geschäftsessen");
        buchungen[5][7] = test;

        Buchung test2 = new Buchung(Buchung.buchungszaehler, "haber", 5, 2, 6, false, "geschäftsessen");
        buchungen[6][7] = test;


        for (int wochentag = 0; wochentag < buchungen.length; wochentag++) {
            System.out.print("Tag " + wochentag + ": ");
            for (int uhrzeit = 0; uhrzeit < buchungen[wochentag].length; uhrzeit++) {
                if (buchungen[wochentag][uhrzeit] == null) {
                    System.out.print("Frei ");
                } else {
                    System.out.print(buchungen[wochentag][uhrzeit].getBuchungsnummer() + " ");
                }


            }
            System.out.println();
        }
    }
}