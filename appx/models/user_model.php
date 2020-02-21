<?php
class User_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	public function Busca()
	{


		$query = $this->db->query('select Usuario,Id, Concat(Nombres," ",PrimerApellido," ",SegundoApellido)Nombre
		     from usuario where Valido=1;');

		return $query->result();
	}
		public function BuscaSinNull()
	{


		$query = $this->db->query('select Usuario,Id, Concat(Nombres,PrimerApellidO,SegundoApellido)Nombre,
		    (select huella from huella where huella.usuario = usuario.usuario limit 1) Huella from usuario where Valido=1 and
		        (select huella from huella where huella.usuario = usuario.usuario limit 1) is NOT NULL;');

		return $query->result();
	}
	public function Agrega($data)
	{
        
        $this->db->select('huella')
		->from('huella')
		->where('usuario',$data["usuario"]);
		$query = $this->db->get();
		
        if($query->num_rows() >= 1)
        {
               $this->db->where('usuario',  $data["usuario"]);
              return $this->db->update('huella',$data); 
        }
        
		return $this->db->insert('huella', $data);
	}
	public function AgregaToken($data)
	{
        
        $this->db->where("usuario", $data['usuario']);
		$this->db->delete("token");
		return $this->db->insert('token', $data);
	}
	public function BuscaById($huella)
	{

        	$this->db->select('usuario')
			->from('huella')
			->where('huella',$huella);
		$query = $this->db->get();
		if($query->num_rows() >= 1)
        {
            	$ret = $query->row();
                return $ret->usuario;
		        
        }
        return "notfound";
	}
}
