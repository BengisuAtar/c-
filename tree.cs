using System;

public class Dugum
{
    public int Veriler;
    public Dugum Sol;
    public Dugum Sag;

    public Dugum(int veriler)
    {
        Veriler = veriler;
        Sol = Sag = null;
    }
}

public class Agac
{
    public Dugum Kök;

    public Agac()
    {
        Kök = null;
    }

    // Preorder Traversal (Önce-Kök Dolaşma)
    public void Preorder(Dugum dugum)
    {
        if (dugum == null) return;

        Console.Write(dugum.Veriler + " ");
        Preorder(dugum.Sol);
        Preorder(dugum.Sag);
    }

    // Inorder Traversal (İç-Kök Dolaşma)
    public void Inorder(Dugum dugum)
    {
        if (dugum == null) return;

        Inorder(dugum.Sol);
        Console.Write(dugum.Veriler + " ");
        Inorder(dugum.Sag);
    }

    // Postorder Traversal (Sonra-Kök Dolaşma)
    public void Postorder(Dugum dugum)
    {
        if (dugum == null) return;

        Postorder(dugum.Sol);
        Postorder(dugum.Sag);
        Console.Write(dugum.Veriler + " ");
    }

    public static void Main(string[] args)
    {
        Agac agac = new Agac();
        agac.Kök = new Dugum(1);
        agac.Kök.Sol = new Dugum(2);
        agac.Kök.Sag = new Dugum(3);
        agac.Kök.Sol.Sol = new Dugum(4);
        agac.Kök.Sol.Sag = new Dugum(5);
        agac.Kök.Sag.Sol = new Dugum(6);
        agac.Kök.Sag.Sag = new Dugum(7);

        Console.WriteLine("Preorder Traversal:");
        agac.Preorder(agac.Kök);
        Console.WriteLine();

        Console.WriteLine("Inorder Traversal:");
        agac.Inorder(agac.Kök);
        Console.WriteLine();

        Console.WriteLine("Postorder Traversal:");
        agac.Postorder(agac.Kök);
        Console.WriteLine();
    }
}