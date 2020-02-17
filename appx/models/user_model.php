<?php
class user_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	public function Busca()
	{


		$this->db->select('Id, Nombres , PrimerApellido , SegundoApellido,
		 CONCAT(Nombres,\' \',PrimerApellido, \' \',SegundoApellido) NombreCompleto
		 , Usuario , Password, Valido, Rol , Rfc, 
		FechaCrea, UsuarioCrea, IFNULL((select usuarioexamen.Id from usuarioexamen where usuarioexamen.Usuario_Id= usuario.Id
			and usuarioexamen.Valido = 1 and usuarioexamen.Status in (1,2) LIMIT 1),0) TieneExamen')
			->from('usuario');
		$query = $this->db->get();
		return $query->result();
	}
	public function BuscaById($id)
	{


		$this->db->select('Id, Nombres , PrimerApellido , SegundoApellido,
		 CONCAT(Nombres,\' \',PrimerApellido, \' \',SegundoApellido) NombreCompleto
		 , Usuario , Password, Valido, Rol , Rfc, 
		FechaCrea, UsuarioCrea, IFNULL((select usuarioexamen.Id from usuarioexamen where usuarioexamen.Usuario_Id= usuario.Id
			and usuarioexamen.Valido = 1 and usuarioexamen.Status in (1,2) LIMIT 1),0) TieneExamen')
			->from('usuario')
			->where('Id',$id);
		$query = $this->db->get();
		return $query->result();
	}
}
