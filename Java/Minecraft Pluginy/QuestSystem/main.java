package com.lupe.hopperfilter;

import java.io.File;
import java.io.IOException;
import java.io.LineNumberReader;
import java.io.StringReader;
import java.io.StringWriter;
import java.nio.file.Files;
import java.nio.file.StandardOpenOption;
import java.util.ArrayList;
import java.util.List;
import java.util.Set;
import java.util.stream.Collectors;

import org.bukkit.Bukkit;
import org.bukkit.Location;
import org.bukkit.Material;
import org.bukkit.World;
import org.bukkit.block.BlockFace;
import org.bukkit.configuration.InvalidConfigurationException;
import org.bukkit.configuration.file.FileConfiguration;
import org.bukkit.configuration.file.YamlConfiguration;
import org.bukkit.entity.Player;
import org.bukkit.event.EventHandler;
import org.bukkit.event.Listener;
import org.bukkit.event.block.Action;
import org.bukkit.event.block.BlockBreakEvent;
import org.bukkit.event.block.BlockPlaceEvent;
import org.bukkit.event.inventory.InventoryClickEvent;
import org.bukkit.event.inventory.InventoryMoveItemEvent;
import org.bukkit.event.player.PlayerInteractEvent;
import org.bukkit.inventory.Inventory;
import org.bukkit.inventory.ItemStack;
import org.bukkit.inventory.meta.ItemMeta;
import org.bukkit.plugin.java.JavaPlugin;

public class main extends JavaPlugin implements Listener {
	 public File databaseFile;
	 public FileConfiguration database;

	 public static Inventory myInventory = Bukkit.createInventory(null, 18, "Hopper System");
	 public static Inventory potvrzovaci = Bukkit.createInventory(null, 9, "potvrdit");
		File databaseFile2 = new File(getDataFolder(), "database.yml");
		YamlConfiguration database2 = YamlConfiguration.loadConfiguration(databaseFile2);
		 String matrovhopperu;
	 public Location latesthopper;
	 String lokace_blok;
	 File customConfigFile= new File(getDataFolder(), "database.yml");
	 static YamlConfiguration customConfig ;
	    public static FileConfiguration config;
	    File cfile;
	 public Material latestblock;
	 public List<String> seznam;
		@Override
		 public void onEnable(){

		     getServer().getPluginManager().registerEvents(this, this);
		         databaseFile = new File(getDataFolder(), "database.yml");
		             config = YamlConfiguration.loadConfiguration(databaseFile2);
		         cfile = new File(getDataFolder(), "config.yml");
		        if (!databaseFile.exists()) {
		        	databaseFile.getParentFile().mkdirs();
		            saveResource("database.yml", false);
		         }
		        if (!cfile.exists()) {
		        	cfile.getParentFile().mkdirs();
		            saveResource("config.yml", false);
		         }
		        
					  System.out.println("Starting HopperFilter...");
					  System.out.println("You can support author with donate! http://paypal.me/LupeCZZ");
						String root1 = this.getDataFolder().getAbsolutePath();
						File file = new File(root1 + "/database.yml");
						if (!file.exists()) {
							System.out.println("Creating new database.yml...");
							
							this.saveDefaultConfig();
				}
						else {
							System.out.println("Config found.");
		 }

						
	}
		public void potvrzeni2(Location loc, Material m, String p) throws IOException {
			database2 = YamlConfiguration.loadConfiguration(databaseFile2);
			seznam = database2.getStringList("Hoppers."+loc+".blocks");			
			int x = (int) loc.getX();
			int y = (int) loc.getY();

			int z = (int) loc.getZ();
	
		 if (seznam.size() == 1) {
			 String error = getConfig().getString("Messages.Hopper_first_item");
			 error = error.replace("&", "§");
			 Bukkit.getPlayer(p).sendMessage(error);
			 Bukkit.getServer().getPlayer(p).closeInventory();
			 
			 
		 }
		 else {
				database2.save(databaseFile2);
				
			YamlConfiguration.loadConfiguration(databaseFile2);
			database2= YamlConfiguration.loadConfiguration(databaseFile2);
			 List<String> list2 = this.database2.getStringList("Hoppers."+loc+".blocks");

		      Bukkit.getPlayer(p).closeInventory();
		      String messageblockremoved = this.getConfig().getString("Messages.Block_removed_from_list");
		      messageblockremoved = messageblockremoved.replace("%block%", m.toString());
		      messageblockremoved = messageblockremoved.replace("&", "§");
		      Bukkit.getPlayer(p).sendMessage(messageblockremoved);
		      Bukkit.getServer().getPlayer(p).closeInventory();
			     int index = list2.indexOf(m.toString());
			     list2.remove(index);
			     this.database2.set("Hoppers."+loc+".blocks", list2);
			     this.database2.save(this.databaseFile2);
				//database2.save(databaseFile2);
			//	YamlConfiguration.loadConfiguration(databaseFile2);
				//database2= YamlConfiguration.loadConfiguration(databaseFile2);
		      
		}
		}
		public void potvrzeni(String p, ItemStack item) {

			ItemStack itemm = new ItemStack(Material.EMERALD_BLOCK, 1);
		  ItemMeta meta1 = itemm.getItemMeta();
		  String menunameaccept= this.getConfig().getString("Menu.confirm.title");
		  menunameaccept = menunameaccept.replace("&", "§");
		  potvrzovaci = Bukkit.createInventory(null, 9, menunameaccept);
		  String menuaccept = this.getConfig().getString("Menu.confirm.meta_accept.displayname");
		  menuaccept = menuaccept.replace("%block%", item.getType().toString());
		  menuaccept = menuaccept.replace("&", "§");
		  meta1.setDisplayName(menuaccept);
		  ArrayList<String> Lore = new ArrayList<String>();
		  String menulore= this.getConfig().getString("Menu.confirm.meta_accept.lore");
		  menulore = menulore.replace("%block%", item.getType().toString());
		  menulore = menulore.replace("&", "§");
		  Lore.add(menulore);
		  meta1.setLore(Lore);
		  itemm.setItemMeta(meta1);
		  potvrzovaci.setItem(3, itemm); 
		  	
		 itemm = new ItemStack(Material.REDSTONE_BLOCK, 1);  
		  ItemMeta meta2 = itemm.getItemMeta();
		  String menuarejectm= this.getConfig().getString("Menu.basic.description.remove_accept");
		  String menureject = this.getConfig().getString("Menu.confirm.meta_reject.displayname");
		  menureject = menureject.replace("%block%", item.getType().toString());
		  menureject = menureject.replace("&", "§");
		  meta2.setDisplayName(menureject);
		  String menurlore= this.getConfig().getString("Menu.confirm.meta_reject.lore");
		  ArrayList<String> Lore2 = new ArrayList<String>();
		  menurlore = menurlore.replace("%block%", item.toString());
		  menurlore = menurlore.replace("&", "§");
		  Lore2.add(menurlore);
		  meta2.setLore(Lore2);
		  itemm.setItemMeta(meta2);
		  potvrzovaci.setItem(5, itemm);   
		   Bukkit.getServer().getPlayer(p).openInventory(potvrzovaci);
		}
		@EventHandler
		public void onPlace(BlockPlaceEvent event) throws IOException {
			if (event.getPlayer().hasPermission("HopperFilter.use")) { 
				seznam = null;	
			if (event.getPlayer().getItemInHand().getType() == Material.HOPPER	) {
		
				File databaseFile2 = new File(getDataFolder(), "database.yml");
				YamlConfiguration database2 = YamlConfiguration.loadConfiguration(databaseFile2);
				Location loc = event.getBlock().getLocation();
				database2.set("Hoppers."+loc+".owner", event.getPlayer().getName().toString()); 
				database2.save(databaseFile2);
				
				        }
			}
		}
		

	@EventHandler 
	public void onDestroy(BlockBreakEvent event) throws IOException{ 
		if (event.getBlock().getType() == Material.HOPPER ) {
	  File databaseFile2 = new File(getDataFolder(), "database.yml");
	  YamlConfiguration.loadConfiguration(databaseFile2);
	  Location loc = event.getBlock().getLocation();
	  String replace = "Hoppers."+loc;
	  database2.set(replace, null);
	  database2.save(databaseFile2); 
		 YamlConfiguration.loadConfiguration(databaseFile2);
         YamlConfiguration database2 = YamlConfiguration.loadConfiguration(databaseFile2);
	  } }
	 	
		
	    @EventHandler
	    public void onInventoryClick(InventoryClickEvent event) throws IOException {
	    
	    Inventory inventory = event.getInventory();

	    if (inventory.getName().equals(myInventory.getName())) { 
		    latestblock = event.getCurrentItem().getType();
           if (event.getCurrentItem().getType() != Material.AIR) { 
	        potvrzeni(event.getWhoClicked().getName(), event.getCurrentItem());
	         event.setCancelled(true); 
           }
	   
	    }


	    else if (inventory.getName().equals(potvrzovaci.getName())) {
	    	if (event.getCurrentItem().getType() == Material.EMERALD_BLOCK) {
		      potvrzeni2(latesthopper, latestblock, event.getWhoClicked().getName());
		     

	    	}
	    	if (event.getCurrentItem().getType() == Material.REDSTONE_BLOCK) {
	    		event.setCancelled(true);
	    		event.getWhoClicked().closeInventory();
	    	}
	    	
	    }

	    }
	    
	    


	 public List <Material> materialy;
		@EventHandler
	public void onClick(PlayerInteractEvent event) throws IOException {
		
			if (event.getAction() == Action.LEFT_CLICK_AIR || event.getAction() == Action.RIGHT_CLICK_AIR) {
				
			}
			else {
				if (event.getPlayer().hasPermission("HopperFilter.use")) {
					 YamlConfiguration.loadConfiguration(databaseFile2);
					if (event.getClickedBlock().getType() != null && event.getAction() == Action.RIGHT_CLICK_BLOCK ) {
						
								if (event.getClickedBlock().getType().equals(Material.HOPPER)) {
							
						         Bukkit.getPluginManager().getPlugin("HopperFilter").getResource("database.yml");
						         File databaseFile2 = new File(this.getDataFolder(), "database.yml");
								 YamlConfiguration.loadConfiguration(databaseFile2);
						         YamlConfiguration database2 = YamlConfiguration.loadConfiguration(databaseFile2);
						         Location loc = event.getClickedBlock().getLocation();
								String owner = database2.getString("Hoppers."+loc+".owner");
								if (owner != null) {
									
									if (event.getPlayer().getItemInHand().getType().equals(Material.AIR)) {

										event.setCancelled(true);
			
										database2= YamlConfiguration.loadConfiguration(databaseFile2);
										seznam = database2.getStringList("Hoppers."+loc+".blocks");					                            
										String menuname= this.getConfig().getString("Menu.basic.title");
										menuname = menuname.replace("&", "§");
										potvrzovaci = Bukkit.createInventory(null, 9, menuname);
										if (seznam.size() > 45) {
					
											myInventory = Bukkit.createInventory(null, 54, menuname);
										}
										else if (seznam.size() > 36) {
											myInventory = Bukkit.createInventory(null, 45, menuname);
										}
										else if (seznam.size() > 27) {
											myInventory = Bukkit.createInventory(null, 36, menuname);
										}
										else if (seznam.size() > 18) {
											myInventory = Bukkit.createInventory(null, 27, menuname);
										}
										else if (seznam.size() > 9) {
											myInventory = Bukkit.createInventory(null, 18,  menuname);
										}
										else if (seznam.size() < 9 && seznam.size() != 0) { 
											myInventory = Bukkit.createInventory(null, 9, menuname);
										}
										else {
											String hoppernotset = this.getConfig().getString("Messages.Hopper_empty");
											hoppernotset = hoppernotset.replace("&", "§");
											event.setCancelled(true);
											event.getPlayer().sendMessage(hoppernotset);
										}
										latesthopper = event.getClickedBlock().getLocation();
										int i =0;
										 loc = event.getClickedBlock().getLocation();
										if (database2.getStringList("Hoppers."+loc+".blocks") != null) {
											seznam = database2.getStringList("Hoppers."+loc+".blocks");	
										}
										for (String s : seznam) {
											Material m = Material.getMaterial(s);
										
											myInventory.setItem(i, new ItemStack(m, 1));
											i = i+1;

										}
										
										event.getPlayer().openInventory(myInventory);
										}
									
									else {
										if (event.getPlayer().isSneaking()) {
										
											if (event.getPlayer().hasPermission("HopperFilter.use")) {
										
												if (event.getPlayer().getItemInHand().getType() == Material.CHEST | event.getPlayer().getItemInHand().getType() == Material.TRAPPED_CHEST | event.getPlayer().getItemInHand().getType() == Material.HOPPER){
				
												}
												else{
													
													YamlConfiguration.loadConfiguration(databaseFile2);
													event.setCancelled(true);
													loc = event.getClickedBlock().getLocation();
													List<String> list = database2.getStringList("Hoppers."+loc+".blocks");
													if (list.contains(event.getPlayer().getItemInHand().getType().toString())) {
														
														String blockalreadyadded = this.getConfig().getString("Messages.This_block_is_already_in_list");
														blockalreadyadded = blockalreadyadded.replace("&", "§");
														event.getPlayer().sendMessage(blockalreadyadded);
														event.setCancelled(true);
														return;
													}
													else if (list.size() == 54) {
														String maxblockserror = this.getConfig().getString("Messages.Maxblocks_reached");
														maxblockserror = maxblockserror.replace("&", "§");
														event.getPlayer().sendMessage(maxblockserror);
			 
													}
													else {
        	
														if (list.isEmpty()) {
													
															 loc = event.getClickedBlock().getLocation();
															List<String> list2 = database2.getStringList("Hoppers."+loc+".blocks"); 
															list2.add(event.getItem().getType().toString());
															database2.set("Hoppers."+loc+".blocks", list2); 
															database2.save(databaseFile2);
															YamlConfiguration.loadConfiguration(databaseFile2);
															database2= YamlConfiguration.loadConfiguration(databaseFile2);
															String newblockadded = this.getConfig().getString("Messages.New_block_added_sucessfully");
															newblockadded = newblockadded.replace("&", "§");
															newblockadded = newblockadded.replace("%block%", event.getPlayer().getItemInHand().getType().toString());
															event.getPlayer().sendMessage(newblockadded);
															database2.save(databaseFile2);										
															YamlConfiguration.loadConfiguration(databaseFile2);
															database2= YamlConfiguration.loadConfiguration(databaseFile2);
															
															

														}
														else {
															list.add(event.getItem().getType().toString());
															 loc = event.getClickedBlock().getLocation();
															database2.set("Hoppers."+loc+".blocks", list); 
															database2.save(databaseFile2);
															YamlConfiguration.loadConfiguration(databaseFile2);
															database2= YamlConfiguration.loadConfiguration(databaseFile2);
															String newblockadded = this.getConfig().getString("Messages.New_block_added_sucessfully");
															newblockadded = newblockadded.replace("&", "§");
															newblockadded = newblockadded.replace("%block%", event.getPlayer().getItemInHand().getType().toString());
															
															event.getPlayer().sendMessage(newblockadded);
															YamlConfiguration.loadConfiguration(databaseFile2);
															List<String> pridanyblokytemp = new ArrayList<String>(); 
															database2.save(databaseFile2);										
															YamlConfiguration.loadConfiguration(databaseFile2);
															database2= YamlConfiguration.loadConfiguration(databaseFile2);
													
			
															
														}
													}
												}
											}	
										}
									}
								}
						}
					}
				}	
			}
		}

	@EventHandler

	   public void onHopperPickup(InventoryMoveItemEvent e) {
	      File databaseFile2 = new File(this.getDataFolder(), "database.yml");
	      YamlConfiguration database2 = YamlConfiguration.loadConfiguration(databaseFile2);
	      YamlConfiguration.loadConfiguration(databaseFile2);
	      int lokaceX = e.getSource().getLocation().getBlockX();
	      int lokaceY = e.getSource().getLocation().getBlockY();
	      int lokaceZ = e.getSource().getLocation().getBlockZ();
	      World world = e.getSource().getLocation().getWorld();
	      Location loc = new Location(world, (double)lokaceX, (double)(lokaceY - 1), (double)lokaceZ);
	      String owner = database2.getString("Hoppers." + loc + ".owner");
	      if(owner != null) {
	         if(!e.getSource().getType().toString().equals("HOPPER") && !e.getSource().getLocation().getBlock().getRelative(BlockFace.DOWN).getType().toString().equals("CHEST") ||!e.getSource().getLocation().getBlock().getRelative(BlockFace.DOWN).getType().toString().equals("TRAPPED_CHEST")){
	      
		    	  List<String> projit = database2.getStringList("Hoppers." + e.getDestination().getLocation() + ".blocks");
		         if(!projit.contains(e.getItem().getType().toString())) {
		            e.setCancelled(true);
	        	 e.setCancelled(true);
	         }
	         
	      } else if(!e.getSource().getType().toString().equals("HOPPER") && !e.getSource().getLocation().getBlock().getRelative(BlockFace.DOWN).getType().toString().equals("CHEST") ||!e.getSource().getLocation().getBlock().getRelative(BlockFace.DOWN).getType().toString().equals("TRAPPED_CHEST")  ) {
             List<String> projit = database2.getStringList("Hoppers." + e.getDestination().getLocation() + ".blocks");
	      
	         if(!projit.contains(e.getItem().getType().toString())) {
	            e.setCancelled(true);
	         }
	      }

	   }
	}
}
