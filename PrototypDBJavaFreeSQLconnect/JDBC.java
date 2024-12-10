
//https://www.youtube.com/watch?v=e8g9eNnFpHQ Java mysql connector herunterladen!

import java.sql.*;
import java.util.ArrayList;

public class JDBC {

        Connection verbindung;

        public JDBC() {
            try {
            verbindung = DriverManager.getConnection(
                    "jdbc:mysql://sql11.freesqldatabase.com:3306/sql11700785",
                    "sql11700785", "restaurantteam1backend");

            } catch (Exception e){
            e.printStackTrace();
            }
        }

        void einfuegen(int eingabeInt1,int eingabeInt2,int eingabeInt3,String eingabeStr1,String eingabeStr2,String eingabeStr3) throws SQLException {
            PreparedStatement inputTest = verbindung.prepareStatement("INSERT INTO buchungen(gastName, datum, anzahlPersonen, id_Tisch, id_Mitarbeiter, kommentar) VALUES (?, ?, ?, ?, ?, '"+eingabeStr3+"')");
                inputTest.setString(1, eingabeStr1);
                inputTest.setString(2, eingabeStr2);
                inputTest.setInt(3, eingabeInt1);
                inputTest.setInt(4, eingabeInt2);
                inputTest.setInt(5, eingabeInt3);
                //inputTest.setString(6, eingabeStr3);
                inputTest.executeUpdate();
        }

        void abfragen(int eingabeInt1) throws SQLException {
            Statement statement = verbindung.createStatement();
            ResultSet resultSet = statement.executeQuery("SELECT * FROM buchungen WHERE id_Buchung = "+eingabeInt1+";");
            while (resultSet.next()) {
                for (int i = 1; i < 8; i++) {
                    ResultSetMetaData rsmd = resultSet.getMetaData();
                    String name = rsmd.getColumnName(i);
                    System.out.print(name+": ");
                    System.out.println(resultSet.getString(i));
                }
            }
        }

        void suchen(String eingabeStr1) throws SQLException {
            Statement statement = verbindung.createStatement();
            ResultSet resultSet = statement.executeQuery("SELECT * FROM buchungen WHERE gastName LIKE '%"+eingabeStr1+"%';");
            while (resultSet.next()) {
                System.out.print(resultSet.getString(1));
                System.out.print(resultSet.getString(2));
                System.out.print(resultSet.getString(3));
                System.out.println();
            }
        }

        void anzeigenAlles () throws SQLException {
            Statement statement = verbindung.createStatement();
            ResultSet resultSet = statement.executeQuery("SELECT * FROM buchungen;");

            while (resultSet.next()) {
                System.out.print("Buchung Nmr: "+resultSet.getString(1)+", ");
                System.out.println("Name: "+resultSet.getString(2));
            }
        }

        void loeschen (int eingabeInt1) throws SQLException {
            PreparedStatement inputTest = verbindung.prepareStatement("DELETE FROM buchungen WHERE id_Buchung = "+eingabeInt1+";");
            inputTest.executeUpdate();
        }

        void trennen () throws SQLException {
            verbindung.close();
        }

        ArrayList<Integer> pruefenObFrei (String eingabeStr2) throws SQLException {
            Statement statement = verbindung.createStatement();
            ResultSet resultSet2 = statement.executeQuery("SELECT * FROM tische;");
            ArrayList<Integer> arrayList = new ArrayList<>();
            while (resultSet2.next()) {
                arrayList.add(resultSet2.getInt(1));
            }
            ResultSet resultSet = statement.executeQuery("SELECT * FROM buchungen WHERE datum = '"+eingabeStr2+"';");
            while (resultSet.next()){
                arrayList.removeIf(e -> {
                    try {
                        return e.equals (resultSet.getInt(5));
                    } catch (SQLException ex) {
                        throw new RuntimeException(ex);
                    }
                });
            }
            return arrayList;
        }
}
