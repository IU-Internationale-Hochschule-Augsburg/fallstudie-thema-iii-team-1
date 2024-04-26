public class Buchung {

    // Instanzvariablen
    private int buchungsnummer;
    public static int buchungszaehler = 0;
    private String gastNachname;
    private int wochentag;
    private int uhrzeit;
    private int anzahlPersonen;
    private int tisch_id;
    private int mitarbeiter_id;
    private boolean kinderstuhl;
    private String kommentar;


    // Konstruktor
    public Buchung(String gastNachname, int anzahlPersonen, int tisch_id, int mitarbeiter_id, boolean kinderstuhl, String kommentar) {

        this.buchungsnummer = ++buchungszaehler;
        this.gastNachname = gastNachname;
        this.anzahlPersonen = anzahlPersonen;
        this.tisch_id = tisch_id;
        this.mitarbeiter_id = mitarbeiter_id;
        this.kinderstuhl = kinderstuhl;
        this.kommentar = kommentar;
    }

    public Buchung ()
    {buchungsnummer = ++buchungszaehler;}



    // Getter & Setter
    public int getBuchungsnummer() {
        return buchungsnummer;
    }

    public void setBuchungsnummer(int buchungsnummer) {
        this.buchungsnummer = buchungsnummer;
    }

    public static int getBuchungszaehler() {
        return buchungszaehler;
    }

    public static void setBuchungszaehler(int buchungszaehler) {
        Buchung.buchungszaehler = buchungszaehler;
    }

    public String getGastNachname() {
        return gastNachname;
    }

    public void setGastNachname(String gastNachname) {
        this.gastNachname = gastNachname;
    }

    public int getAnzahlPersonen() {
        return anzahlPersonen;
    }

    public void setAnzahlPersonen(int anzahlPersonen) {
        this.anzahlPersonen = anzahlPersonen;
    }

    public int getTisch_id() {
        return tisch_id;
    }

    public void setTisch_id(int tisch_id) {
        this.tisch_id = tisch_id;
    }

    public int getMitarbeiter_id() {
        return mitarbeiter_id;
    }

    public void setMitarbeiter_id(int mitarbeiter_id) {
        this.mitarbeiter_id = mitarbeiter_id;
    }

    public boolean isKinderstuhl() {
        return kinderstuhl;
    }

    public void setKinderstuhl(boolean kinderstuhl) {
        this.kinderstuhl = kinderstuhl;
    }

    public String getKommentar() {
        return kommentar;
    }

    public void setKommentar(String kommentar) {
        this.kommentar = kommentar;
    }

    public int getWochentag() {
        return wochentag;
    }

    public void setWochentag(int wochentag) {
        this.wochentag = wochentag;
    }

    public int getUhrzeit() {
        return uhrzeit;
    }

    public void setUhrzeit(int uhrzeit) {
        this.uhrzeit = uhrzeit;
    }
}
