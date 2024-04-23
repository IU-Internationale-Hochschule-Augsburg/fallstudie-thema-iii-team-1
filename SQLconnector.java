import java.net.ConnectException;
import java.sql.*;

public class SQLconnector {


    public SQLconnector(){

        try {
        Connection verbindung = DriverManager.getConnection("jdbc:mysql://sql11.freesqldatabase.com:3306/sql11700785", "sql11700785", "restaurantteam1backend");

        Statement statement = verbindung.createStatement();

        PreparedStatement inputTest = verbindung.prepareStatement("insert into tische (anzahlPlaetze) VALUES('7');");
        //inputTest.setString(1, );
        inputTest.executeUpdate();

        ResultSet resultSet = statement.executeQuery("SELECT * FROM tische");

        while (resultSet.next()) {
            System.out.println(resultSet.getString("anzahlPlaetze"));
        }
        } catch (Exception e){
            e.printStackTrace();
        }



    }


}
