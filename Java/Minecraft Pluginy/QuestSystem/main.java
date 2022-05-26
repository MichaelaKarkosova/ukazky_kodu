package com.lupe.questsystem;

import java.net.InetSocketAddress;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.List;

import org.bukkit.Material;
import org.bukkit.entity.EntityType;
import org.bukkit.entity.Player;
import org.bukkit.event.EventHandler;
import org.bukkit.event.Listener;
import org.bukkit.event.player.PlayerInteractEntityEvent;
import org.bukkit.event.player.PlayerInteractEvent;
import org.bukkit.event.player.PlayerItemHeldEvent;
import org.bukkit.event.player.PlayerMoveEvent;
import org.bukkit.inventory.ItemStack;
import org.bukkit.plugin.java.JavaPlugin;

import net.citizensnpcs.api.CitizensAPI;
import net.citizensnpcs.api.event.NPCClickEvent;
import net.citizensnpcs.api.npc.NPC;



public class main extends JavaPlugin implements Listener {
	   private Connection connection;
	    private String host, database, username, password;
	    private int port;
	    public Player clickedplayer;
	    public  Statement statement;


@Override
public void onEnable() {  
    getServer().getPluginManager().registerEvents(this, this);
    host = "89.203.249.188";
    port = 3306;
    database = "Questy";
    username = "lupe";
    password = "*********";    
    try {    
        openConnection();
      statement = connection.createStatement();            
    } catch (ClassNotFoundException e) {
        e.printStackTrace();
    } catch (SQLException e) {
        e.printStackTrace();
    }
    
}

public void openConnection() throws SQLException, ClassNotFoundException {
    if (connection != null && !connection.isClosed()) {
        return;
    }
 
    synchronized (this) {
        if (connection != null && !connection.isClosed()) {
            return;
        }
        Class.forName("com.mysql.jdbc.Driver");
        connection = DriverManager.getConnection("jdbc:mysql://" + this.host+ ":" + this.port + "/" + this.database, this.username, this.password);
        System.out.println("Opened!");

       
    }
}
@EventHandler
public void onClickNPC (PlayerInteractEntityEvent event) {
	

	if (event.getRightClicked().getName().equals("§b§lChovatel")) {
	clickedplayer = event.getPlayer();

	}
}
    @EventHandler
    public void onQuestTake (net.citizensnpcs.api.event.NPCRightClickEvent event) throws SQLException {


    if (event.getNPC().getFullName().toString().equals("§b§lChovatel")) {
   
     
      String values = "'"+clickedplayer.getName()+"', '1', 'CEKA'";
 
      ResultSet result =  statement.executeQuery("select * from hraci where hrac='"+clickedplayer.getName()+"'");
     
      String stav = "";

      while (result.next()) {
    	 stav = result.getString("stav");
      }
      if (stav.toString().equals("CEKA")) {
    	  statement.executeUpdate("update hraci set stav = 'PROBIHA' where quest_id = 1 and hrac = '"+clickedplayer.getName()+"';");
    	  clickedplayer.sendMessage("§b§lZatoulal se, přiveď ho prosím ke mě. Má moc rád syrové ovčí maso!");
      }
      else if (stav.toString().equals("HOTOVO")) {
    	  clickedplayer.sendMessage("§aDěkuji za nalezeni meho psa. Momentálně s ničím dalším pomoc nepotřebuji!");
      }
      else {
    	  statement.executeUpdate("INSERT INTO hraci (hrac, quest_id, stav) VALUES ("+values+");");
    	  clickedplayer.sendMessage("§b§lPomůžeš mi najit psa?");
      
    }
    }
    
    


}
    @EventHandler
    public void onItemChange (PlayerItemHeldEvent event) throws SQLException {
    	Player p =event.getPlayer();
    	int slot = event.getNewSlot();
    	ItemStack mat = event.getPlayer().getInventory().getItem(slot);
	      if (mat != null) {
    	if (mat.toString().contains("MUTTON")) {
    	      ResultSet result =  statement.executeQuery("select * from hraci where hrac='"+event.getPlayer().getName()+"'");
    	      if (result != null) {
    	      String stav = "";

    	      while (result.next()) {
    	    	 stav = result.getString("stav");
    	      }
    	      if (stav.toString().equals("PROBIHA")) {
    		NPC npc =  CitizensAPI.getNPCRegistry().getById(3);
    		if (npc.getStoredLocation().distance(p.getLocation()) < 10) {
    		
    		npc.getNavigator().setTarget(p.getLocation());
    		}
    	  	 NPC chovatel = CitizensAPI.getNPCRegistry().getById(2);
        	 NPC pes = CitizensAPI.getNPCRegistry().getById(3);
        	 if (pes.getStoredLocation().distance(chovatel.getStoredLocation() )< 2) {
        		   result =  statement.executeQuery("select * from hraci where hrac='"+event.getPlayer().getName()+"'");
        	      
          	      while (result.next()) {
          	    	 stav = result.getString("stav");
          	    	 
          	      }
        		 if (stav.toString().equals("PROBIHA")) {
           	  statement.executeUpdate("update hraci set stav = 'HOTOVO' where quest_id = 1 and hrac = '"+event.getPlayer().getName()+"';");
        		 event.getPlayer().sendMessage("§b§lChovatel §f>> §bTo je muj pes! Diky!");
                 odmenit("§b§lChovatel", clickedplayer);
        		 }
        	 }
    	      }
    	      }
        	}
        }
    }
    	//if (event.getNewSlot())
    	

    @EventHandler
    public void onWalkingWhileHoldingMeat(PlayerMoveEvent event) throws SQLException {
    	ItemStack mat = event.getPlayer().getInventory().getItemInMainHand();
    	ItemStack mat2 = event.getPlayer().getInventory().getItemInOffHand();
    	Player p = event.getPlayer();
	      if (mat != null && mat2 != null) {
    	if (mat2.toString().contains("MUTTON") || mat.toString().contains("MUTTON") ) {
  	      ResultSet result =  statement.executeQuery("select * from hraci where hrac='"+event.getPlayer().getName()+"'");
	      
  	      String stav = "";
  	      if (result != null) {
  	      while (result.next()) {
  	    	 stav = result.getString("stav");
  	      }
  	      if (stav.toString().equals("PROBIHA")) {
    		NPC npc =  CitizensAPI.getNPCRegistry().getById(3);
    		if (npc.getStoredLocation().distance(p.getLocation()) > 6  && npc.getStoredLocation().distance(p.getLocation()) < 10) {
    		npc.getNavigator().setTarget(p.getLocation());
    	}
    	 NPC chovatel = CitizensAPI.getNPCRegistry().getById(2);
    	 NPC pes = CitizensAPI.getNPCRegistry().getById(3);
	  	 
    	 if (pes.getStoredLocation().distance(chovatel.getStoredLocation() )< 2) {
    		   result =  statement.executeQuery("select * from hraci where hrac='"+clickedplayer.getName()+"'");
    	      
      	      while (result.next()) {
      	    	 stav = result.getString("stav");
      	      }
    		 if (stav.toString().equals("PROBIHA")) {
       	  statement.executeUpdate("update hraci set stav = 'HOTOVO' where quest_id = 1 and hrac = '"+clickedplayer.getName()+"';");
    		 event.getPlayer().sendMessage("§b§lChovatel §f>> §bTo je muj pes! Diky!");
            odmenit("§b§lChovatel", clickedplayer);
     		

 		 }

 	 }
    		 }
    	 }
    	 }
    	 }

    }
    public void odmenit(String zadavatel, Player name) throws SQLException {
    	int dokonceno =0;
	  	 int karma =0;
	  	 int karmaodmena = 0;
	  	String[] veciodmeny;
	  	 String veciodmena = "";
	     ResultSet result;
	     
	
	  	result =  statement.executeQuery("select * from questy where NPC='"+zadavatel+"'");
	     while (result.next()) {
	   	    	
	   	    	karmaodmena = result.getInt("karma");
	   	    	veciodmena = result.getString("odmena");
	   	    	
	   	      }
	     veciodmeny = veciodmena.split(",");
	     Material mat;
	     ItemStack odmenafinal;
	     String pocett;
	     String vec;
	     int pocet;
	     for (String odmena : veciodmeny){
	    	 System.out.println("loop started");
	    	  vec = odmena.replaceAll("\\d", "");
	    	 vec = vec.toUpperCase();
	    	 System.out.println("replaced vec: "+vec);
		    vec = vec.replaceAll(" ", "");
	    	pocett = odmena.replaceAll("[a-zA-Z]", "");
	    	pocett = pocett.replaceAll(" ", "");
	    
	    	 pocet = Integer.parseInt(pocett);

	    	  mat = Material.matchMaterial(vec);
	    	 odmenafinal = new ItemStack(mat,pocet);
	    	name.getInventory().addItem(odmenafinal);
	     }
		 	result =  statement.executeQuery("select * from statistiky where hrac='"+name.getName()+"'");
	 	      
	   	      while (result.next()) {
	   	    	dokonceno = result.getInt("dokonceno");
	   	    	karma = result.getInt("karma");
	   	      }
	   	      int karmafinal = karma+karmaodmena;
	   	      int dokoncnenofinal =  dokonceno+1;
	 		 statement.executeUpdate("update statistiky set dokonceno="+dokoncnenofinal+" where hrac = '"+name.getName()+"';");
	 		 statement.executeUpdate("update statistiky set karma="+karmafinal+" where hrac = '"+name.getName()+"';");
     		 name.sendMessage("§6+"+karmaodmena+"karmy");
     		 
    }
}
